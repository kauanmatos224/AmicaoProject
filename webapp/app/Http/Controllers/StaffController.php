<?php

//Classe responsável pelas operações de Usuário do tipo funcionário (Administrador da plataforma)

namespace App\Http\Controllers; //Declara o escopo de acesso à classe.

//Importa classes utéis na execução dos métodos seguintes.
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\DB;
use Mail;


//Inicializa a classe extendendo Controller.
class StaffController extends Controller
{

    //Método responsável por obter os cadastros de usuários do tipo instituição da base de dados.
    /*
    **Todo método que performa operações no banco de dados passa pelo método de autenticação
    o qual verifica se o usuário está logado e se contém privilégios para executar as operações.
     */
    public function getView_RegistrationAnalisys(){

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                $data = (new StaffController)->getRegistrationData();
                if($data!=null){
                    if(!empty(session('info_register_analisys'))){
                        return view('registration_analisys')->with('data', $data)->with('info', session('info_register_analisys'));
                    }
                    else{
                        return view('registration_analisys')->with('data', $data);
                    }
                    
                }
                else{
                    return view('error_404');
                }
                
            }
            else{
                return view('error_404');
            }
        }
        else{
            session(['required_route'=>'getView_RegistrationAnalisys', 'router_owner' => 'staff']);
            return view('login');
        }

    }

    public function getRegistrationData(){
        
        $data = DB::select('select * from tb_org inner join tb_auth_org on tb_auth_org.id_org =
        tb_org.id and tb_auth_org.user_type=?', array('inst'));

        if($data){
            return $data;
        }
        else{
            return null;
        }

    }
    

    public function getView_inspectInst(Request $request){
        $id = $request->route('id');
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){

                $data = (new StaffController)->getInstData($id);
                if($data!=null){
                    return view('inspect_inst')
                        ->with('data_org', $data[0][0])
                        ->with('data_auth_org', $data[1][$id]);
                }
                else{
                    return view('error_404');
                }

            }else{
                return view('error_404');
            }
        }else{
            return view('error_404');
        }
    }

    public function getInstData($id){
        $data_org = DB::select('select * from tb_org where id=?', array($id));
        $data_auth = DB::select('select status, email, deletion_date from tb_auth_org where id_org=?', array($id));
        $data_auth_org = array();

        for($i=0; $i<count($data_org); $i++){
            $data_auth_org[$data_org[$i]->id] = $data_auth[$i];
        }

        if($data_org && $data_auth_org){
            return $data = array($data_org, $data_auth_org);
        }
        return null;
    }



    public function deleteInst(Request $request){
        $id = $request->post('_id');
        $justify = $request->post('txtJustify');
        $timestamp = Carbon::now()->timestamp;
        $deletion_date = $timestamp + 2592000; //a month to complete exclusion
        /*if($id==null || empty($id)){
            return view('error_404');
        }*/

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                if($justify!=null || $justify!=""){    
                    $inst_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?) or (id_org=? and status=?))', array($id, 'waiting', $id, 'approved', $id, 'denied'));

                    if($inst_data){
                        DB::update('update tb_auth_org set status=?, deletion_date=?, previously_status=? where id_org=?', array('deleted', $deletion_date, $inst_data[0]->status, $id));
                        session(['info_register_analisys'=>'deleted_register']);

                        (new StaffController)->sendMail($inst_data[0]->email, 'deleted_inst', $justify);
                        
                        return redirect('/staff/inst-analise');
                    }
                }else{
                    return view('collect_justify')->with('id', $id)->with('operation_type', 'deleteInst')->with('info', 'wrong_justify');
                }
                
            }
        }

        return view('error_404');
    }

    public function approveInst(Request $request){
        $id = $request->post('_id');
        $justify = $request->post('txtJustify');
        
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){

                if($justify!=null || $justify!=""){
                    $account_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?))', array($id, 'denied', $id, 'waiting'));
                
                    if($account_data){
                        DB::update('update tb_auth_org set status=?, previously_status=? where id_org=?', array('approved', $account_data[0]->status, $id));
                        
                        session(['info_register_analisys'=>'approved_register']);

                        (new StaffController)->sendMail($account_data[0]->email, 'approved_inst', $justify);

                        return redirect('/staff/inst-analise');
                        
                    }
                }else{
                    return view('collect_justify')->with('id', $id)->with('operation_type', 'approveInst')->with('info', 'wrong_justify');
                }
                    
            }        
        }

        return view('error_404');
    }

    public function restoreInst(Request $request){
        $id=$request->post('_id');
        $justify = $request->post('txtJustify');
        $inst_data = DB::select('select * from tb_auth_org where (id_org=? and status=?)', array($id, 'deleted'));
        $justify = $request->post('txtJustify');


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                if($justify!=null || $justify!=""){
                    if($inst_data){

                        $previously_status = null;

                        if($inst_data[0]->previously_status==null){
                            $previously_status = 'waiting';
                        }
                        else{
                            $previously_status = $inst_data[0]->previously_status;
                        }


                        DB::update('update tb_auth_org set status=?, deletion_date=?, previously_status=? where id_org=?', 
                            array($previously_status, null, $inst_data[0]->status, $id));
                        session(['info_register_analisys'=>'restored_register']);

                        (new StaffController)->sendMail($inst_data[0]->email, 'restored_inst', $justify);

                        return redirect('/staff/inst-analise');

                    }
                }else{
                    return view('collect_justify')->with('id', $id)->with('operation_type', 'restoreInst')->with('info', 'wrong_justify');
                }
            }
        }

        return view('error_404');

    }

    public function denyInst(Request $request){

        $id=$request->post('_id');
        $justify = $request->post('txtJustify');

        $inst_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?))', array($id, 'waiting', $id, 'approved'));


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                
                if($justify!=null || $justify!=""){
                    
                    if($inst_data){
                        DB::update('update tb_auth_org set status=?, previously_status=? where id_org=?', array('denied', $inst_data[0]->status, $id));
                        
                        session(['info_register_analisys'=>'reproved_register']);

                        (new StaffController)->sendMail($inst_data[0]->email, 'reproved_inst', $justify);

                        return redirect('/staff/inst-analise');
                        
                    }
                }else{
                    return view('collect_justify')->with('id', $id)->with('operation_type', 'denyInst')->with('info', 'wrong_justify');
                }
        
            }
        }
        return view('error_404');
        

    }




    public function getView_justifyRestoreInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'restoreInst');
    }

    public function getView_justifyDeleteInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'deleteInst');
    }

    public function getView_justifyApproveInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'approveInst');
    }

    public function getView_justifyDenyInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'denyInst');
    }


    public function getView_Messages(){
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){

                $messages = DB::select('select * from tb_users_faq');
                if($messages){
                    return view('messages_faq')->with('dataset', $messages);
                }   
                else{
                    return view('messages_faq')->with('info', 'none_messages');
                }

            }

        }

        return view('error_404');


    }




    public function getView_inspectMessage(Request $request){
        $id = $request->route('id');


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                $data = DB::select('select * from tb_users_faq where id=?', array($id));

                if($data){
                    return view('inspect_message')->with('data', $data);
                }
            }
        }

        return view('error_404');
    }

    public function deleteMessage(Request $request){
        $id = $request->post('_id');


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                $delete = DB::delete('delete from tb_users_faq where id=?', array($id));
                if($delete){
                    session(['info_message_op' => 'deleted_message']);
                    return redirect('/staff/messages');
                }
            }
        }

        return view('error_404');

        
    }

    public function getView_fixSolicitation(Request $request){
        $id = $request->route('id');

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                return view('fix_message')->with('id', $id);
            }
        }
        return view('error_404');
    }

    public function fixSendAnswer(Request $request){
        $timestamp = Carbon::now()->timestamp;
        $id = $request->post('_id');
        $status = $request->post('txtStatus');
        $answer = $request->post('txtAnswer');


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                if($status=='solved' || $status=='solving'){

                    if($answer=="" || $answer==null){
                        return view('fix_message')->with('id', $id)->with('error', 'wrong_answer');
                    }
                    else{
                        $update = DB::update('update tb_users_faq set last_answer=?, solicitation_status=? where id=?', array($timestamp, $status, $id));

                        if($update){
                            session(['info_message_op'=>"answered_message"]);
                            $data = DB::select('select email from tb_users_faq where id=?', array($id));
                            $email = $data[0]->email;
                            (new StaffController)->sendMail($email, "solicitation_message-$status", $answer);
                            return redirect('/staff/messages');
                        }

                    }
                    
                }
            }
        }

        return view('error_404');
    }

    public function sendMail($send_to, $subject, $justify){
        
        $msg = "";
        
        if($subject=='approved_inst'){
            $subject = "Resultado da análise do seu cadastro de instituição.";
            $msg = "<p>O cadastro da sua instituição foi aprovado, você já pode usar a nossa plataforma para gerenciar sua organização, segue o feedback da nossa plataforma: \" $justify \" !</p>";
        }
        else if($subject=="reproved_inst"){
            $subject = "Resultado da análise do seu cadastro de instituição.";
            $msg = "<p>O cadastro da sua instituição foi reprovado, segue o feedback da nossa plataforma: \" $justify \" </p>";
        }
        else if($subject=="deleted_inst"){
            $subject = "Exclusão da sua conta institucional.";
            $msg = "<p>A sua conta foi movida para exclusão, segundo o motivo: \" $justify \"</p>";
        }
        else if($subject=="restored_inst"){
            $subject = "Restauração do cadastro da sua instituição.";
            $msg = "<p>A sua conta foi restaurada, segue o motivo: \" $justify \"</p>";
        }
        else if($subject=='solicitation_message-solved'){
            $subject = "Resposta sobre a mensagem que você nos enviou.";
            $msg = "<p>Primeiramente agradecemos o seu contato! 
             Segue a resposta da nossa Plataforma:</p> \" $justify \"

             ***Sua mensagem foi avaliada e marcada como uma <strong>solicitação resolvida</strong>, porque sua solicitação pode já ter sido reolvida ou foi categorizada como uma <strong>avaliação de usuário</strong>.";
        }
        else if($subject=='solicitation_message-solving'){
            $subject = "Resposta sobre a mensagem que você nos enviou.";
            $msg = "<p>Primeiramente agradecemos o seu contato! 
            Segue a resposta da nossa Plataforma:</p> \" $justify \"";
        }
        
    
        Mail::send('mail.default',
            ['msg' => $msg],
            function($message) use ($send_to, $subject) {
                $message->to(array($send_to))
                ->subject($subject);
            }
        );
    
    }

}


