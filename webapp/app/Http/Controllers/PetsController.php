<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Http\Requests\PetsAddRequest;
use App\Http\Requests\PetsUpdateRequest;
use File;
use Carbon\Carbon;
use VictorRayan\DropboxRayanVrsrb\Dropbox_FileUpload;
use VictorRayan\DropboxRayanVrsrb\Dropbox_FileDeletion;
use Illuminate\Support\Facades\Storage;
use VictorRayan\DropboxRayanVrsrb\Dropbox_AccessFile;
use App\Http\Controllers\UserAuthController;
use DateTime;
use Mail;

class PetsController extends Controller
{

    public $info = null;
    public function listPets(){
        
        if((new UserAuthController)->checkSession()){
        
            if(session('user_type') == 'inst'){
                $pets = DB::select('select * from tb_pets where id_org=?', array(session('id_org')));

                for($i=0;$i<count($pets);$i++){
                    $img_path = $pets[$i]->img_path;
                    $img_link = (new Dropbox_AccessFile)->getTemporaryLink($img_path);
                    $pets[$i]->img_path=$img_link;
                }
                //dd($this->info);

                $csrf_tk = (new PetsController)->csrf_gen_deletPetPage_gen();
                if($this->info!=null && $this->info!=""){
                    
                    return view('pets')->with('pets', $pets)->with('info', $this->info)->with('csrf_tk', $csrf_tk);    
                }else{
                    return view('pets')->with('pets', $pets)->with('csrf_tk', $csrf_tk);    //->with('info', $info);
                }
            }
            else{
                return view('error_404');
            }
        }
        else{
            session(['required_action' => 'listPets']);
            return view('login');
        }
        
    }

    public function inspectPet(Request $request){
        
        $id=$request->route('id');

        session(['required_route'=>'listPets']);
        $pet = (new PetsController)->select_pet($id);

        if($pet=='not_owned'){
            return view('error_404');
        }
        else if($pet=='not_logged'){
            return view('login');
        }else{
            return view('alterar_pet')->with('pet', $pet);  
        }
        
    }

    public function deletePet(Request $request){

        if((new UserAuthController)->checkSession()){
            
            $csrf_token = $request->route('csrf_token');
            $timestamp = Carbon::now()->timestamp;
            $server_csrf_token = DB::select('select * from tb_csrf_forms where token = ?', array($csrf_token));

            if($server_csrf_token){

                DB::delete('delete from tb_csrf_forms where expiration_at<? or expiration_at=?', array($timestamp, $timestamp));
                

                        $select_token_data = DB::select('select * from tb_csrf_forms where token=?', array($csrf_token));
                       
                        if($select_token_data[0]->expiration_at > $timestamp){

                            $id = $request->route('pet_id');
                            $foto = DB::select('select img_path from tb_pets where id=? and id_org=?',
                            array($id, session('id_org')));
                            
                    
                            if($foto){

                                $delete = DB::delete('delete from tb_reqs where id_pet=?', array($id));
                                $delete = DB::delete('delete from tb_pets where id=?', array($id));
            
                                $this->info = "";
                                if($delete){
            
                                    if(!$foto[0]->img_path == "/no-photo.png"){
                                        if((new Dropbox_FileDeletion)->delete($foto[0]->img_path)){
                                            $this->info="deleted_pet";
                                        }
                                        else{
                                            $this->info="error_delete_pet";    
                                        }
                                    }
                                    
                                }
                                else{
                                    $this->info="error_delete_pet";
                                }
            
                                return redirect()->action([PetsController::class, 'listPets']);
                            }else{
                                return view('error_404');
                            }


                        
                        }
                        else{
                            return view('error_404');
                        }

                    


                
                
                

            }
            
        }
        else{
            session(['required_route'=> 'listPets']);
            return view('login');
        }
    }



    public function updatePet(PetsUpdateRequest $request){

        $id = $request->post('txtCod');
        $nome = $request->post('txtNome');
        $idade = $request->post('txtIdade');
        $raca = $request->post('txtRaca');
        $raca_pai = $request->post('txtRacaP');
        $raca_mae = $request->post('txtRacaM');
        $saude = $request->post('txtSaude');
        $vacinas = $request->post('txtVacinas');
        $porte = $request->post('txtPorte');
        $genero = $request->post('txtGenero');
        $status = $request->post('txtStatus');
        $nascimento = $request->post('txtNascimento');
        $foto = $request->file('inpFoto');
        $img_path = "";

        if((new UserAuthController)->checkSession()){

            $checkOwner = DB::select('select * from tb_pets where id=? and id_org=?',
                array($id, session('id_org')));
            if($checkOwner){

                if($foto!=null && $foto!=""){

                    $timestamp = Carbon::now()->timestamp;
                    $filename = hash('sha256', $foto->getClientOriginalName().
                        $foto->getSize().$foto->getClientOriginalExtension().$timestamp."30/07/2003").
                        ".".$foto->getClientOriginalExtension();

                    $foto->storeAs('/', $filename);
                    $filepath = storage_path('app/'.$filename);
                    $img_path = (new Dropbox_FileUpload)->upload($filepath, '/');

                    $pet_data = (new PetsController)->select_pet($id);

                    if($pet_data=='not_owned'){
                        return view('error_404');
                    }
                    else if($pet_data=='not_logged'){
                        return view('login');
                    }else{
                        (new Dropbox_FileDeletion)->delete(($pet_data)[0]->img_path);
                        Storage::delete($filepath);
                    }


                }else{
                    $img_path_from_db = ((new PetsController)->select_pet($id))[0]->img_path;
                    $img_path = $img_path_from_db;
                    
                    if($img_path_from_db=='not_owned'){
                        return view('error_404');
                    }
                    else if($img_path_from_db=='not_logged'){
                        return view('login');
                    }
                }

                if($nascimento==null){
                    $nascimento = ((new PetsController)->select_pet($id))[0]->nascimento;
                    if($nascimento=='not_owned'){
                        return view('error_404');
                    }
                    else if($nascimento=='not_logged'){
                        return view('login');
                    }
                }

                $update = DB::update('update tb_pets
                set nome = ?,
                idade = ?,
                raca = ?,
                raca_pai = ?, 
                raca_mae = ?,
                saude = ?,
                vacinas_essenciais = ?,
                porte = ?,
                genero = ?,
                status = ?, 
                img_path = ?,
                nascimento = ?
                where id=? ', array($nome, $idade, $raca, $raca_pai, $raca_mae, $saude, $vacinas,
                $porte, $genero, $status, $img_path, $nascimento, $id));

                $op_status ="";
                if($update){
                    $op_status = "update_sucess";
                }
                else{
                    $op_status = "update_fail";
                }
                
                $this->info = $op_status;
                return redirect()->action([PetsController::class, 'listPets']);
            }
            else{
                return view('error_404');
            }
        }else{
            session(['required_route'=>'listPets']);
            return view('login');
        }

    }

    public function insertPet(PetsAddRequest $request){
        $nome = $request->post('txtNome');
        $idade = $request->post('txtIdade');
        $raca = $request->post('txtRaca');
        $raca_pai = $request->post('txtRacaP');
        $raca_mae = $request->post('txtRacaM');
        $saude = $request->post('txtSaude');
        $vacinas = $request->post('txtVacinas');
        $porte = $request->post('txtPorte');
        $genero = $request->post('txtGenero');
        $foto = $request->file('inpFoto');
        $status = $request->post('txtStatus');
        $nascimento = $request->post('txtNascimento');
        $img_path = "";
        

        if((new UserAuthController)->checkSession()){
            if(!empty(session('id_org'))){     
                
                if($foto!=null){
                    $timestamp = Carbon::now()->timestamp;
                    $filename = hash('sha256', $foto->getClientOriginalName().
                    $foto->getSize().$foto->getClientOriginalExtension().$timestamp."30/07/2003").
                        ".".$foto->getClientOriginalExtension();

                    $foto->storeAs('/', $filename);
                    $filepath = storage_path('app/'.$filename);
                    $img_path = (new Dropbox_FileUpload)->upload($filepath, '/');
                    Storage::delete($filepath);
                }
                else{
                    $img_path = '/no-photo.png';
                }
                    
                $insert = DB::insert('insert into tb_pets(nome, idade, raca, raca_pai,
                    raca_mae, saude, vacinas_essenciais, porte, genero, img_path, status, nascimento, id_org) values(
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                    )', array($nome, $idade, $raca, $raca_pai, $raca_mae, $saude, $vacinas,
                            $porte, $genero, $img_path, $status, $nascimento, session('id_org')
                ));

                $info_="";
                if($insert){
                    $info_ = "inserted_pet";
                }
                else{
                    $info_ = "error_inserting_pet";
                }

                $this->info = $info_;
                return redirect()
                    ->action([PetsController::class, 'listPets']);
            }
            else{
                return view('error_404');
            }
        }
        else{
            session(['required_route'=>'getView_cadastra_pet']);
            return view('login');
        }

    }


    public function select_pet($id){
        
        if((new UserAuthController)->checkSession()){
            $data = DB::select('select * from tb_pets where id=? and id_org=?', 
                array($id, session('id_org')));

            if($data){
                
                return $data;
            }
            else{

                return 'not_owned';
                //return view('error_404');
            }
        }
        else{

            session(['required_route'=>'listPets']);
            return 'not_logged';
            
            //return view('login');
        }
        
        
    }


    public function getView_institucional(){
        
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst' || session('user_type')=='staff'){
                return view('institucional')->with('user_type', session('user_type'));
            }else{
                return view('error_404');
            }
        }
        else{
            session(['required_route'=>'getView_institucional']);
            return view('login');
        }
        
    }

    public function getView_requisicoes(){
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst'){
                
                $data = DB::select('select * from tb_reqs');
                if($data){
                    return view('requisicoes')->with('data', $data);
                }
                else {
                    session(['request_info' => 'no_requests']);
                    return view('requisicoes');
                }
                
            }
            else{
                return view('error_404');
            }
        }
        else{
            session(['required_route'=>'getView_requisicoes']);
            return view('login');
        }
        
    }

    public function getView_cadastra_pet(){
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst'){
                return view('cadastrar_pet')->with('user_type', session('user_type'));
            }
            else{
                return view('error_404');
            }
        }
        else{
            session(['required_route'=>'getView_cadastra_pet']);
            return view('login');
        }
    }


    public function csrf_gen_deletPetPage_gen(){
        $timestamp = Carbon::now()->timestamp;
        $expiration = $timestamp + 3600;
        $pageSecret = 'deleteamicao30072003'.session('id_org');
        
        $token = hash('sha256', $pageSecret);

        $insert = DB::insert('insert into tb_csrf_forms(token, expiration_at) values(?, ?)', array($token, $expiration));

        if($insert){
            return $token;
        }
        else{
            return view('error_404');
        }

    }

    public function getView_inspectRequest(Request $request){
        $id = $request->route('id');

        $data = DB::select('select * from tb_reqs where id=?', array($id));

        if($data){
            return view('inspect_req')->with('data', $data[0]);
        }

        return view('error_404');

    }

    public function reqAction(Request $request){
        $id = $request->post('_id');
        $action = $request->post('op_type');


        if($id!=null && $action!=null && ($action=='change' || $action=='repprove' || $action=='approve')){
            if($action=='approve'){
                $approve = DB::update('update tb_reqs set status=? where id=?', array('acceptted', $id));
                if($approve){
                    $data = DB::select('select email, date from tb_reqs where id=?', array($id));
                    (new PetsController)->sendMail($data[0]->email, 'approved_req','',date('d/m/Y H:i:s', $data[0]->date));
                    session(['request_info'=>'approved']);
                    return redirect('/institucional/requisicoes');
                }
            }else{
                $datetime = DB::select('select date from tb_reqs where id=?', array($id));
                return view('collect_req_justify')->with('id', $id)->with('op_type', $action)->with('datetime', $datetime[0]->date);
            }
        }

        return view('error_404');

    }

    public function doAction(Request $request){
        $id = $request->post('_id');
        $action = $request->post('op_type');
        $date_status = $request->post('txtDate_info_obj');
        $justify = $request->post('txtJustify');
        $datetimestamp = $request->post('txtTimestamp');
        $datetime = $request->post('txtDatetime');
        $should_delete = $request->post('txtShouldDelete');
        $validate_date = date('d/m/Y H:i:s', strtotime($datetime));
    
        if($justify!=null && $justify!=""){

            $data = DB::select('select * from tb_reqs where id=?', array($id));
            if($action=='change'){
                if($date_status=='changed'){
                    if($validate_date=='01/01/1970 00:00:00'){
                        return view('collect_req_justify')->with('info', 'wrong_date')->with('op_type', $action)
                        ->with('datetime', $datetimestamp)->with('id', $id);
                    }else{
                        $date_to_database = strtotime($datetime);
                        $update = DB::update('update tb_reqs set status=?, date=? where id=?', array('acceptted', $date_to_database, $id));

                        if($update){
                            (new PetsController)->sendMail($data[0]->email, 'changed_req', $justify, date('d/m/Y H:i:s', $data[0]->date));
                            session(['request_info' => 'changed']);
                            return redirect('/institucional/requisicoes');
                        }
                    }
                }
                else if($date_status=='resetted'){
                    return view('collect_req_justify')->with('info', 'wrong_none_date_set')->with('op_type', $action)
                    ->with('datetime', $datetimestamp)->with('id', $id);
                }else{
                    return view('error_404');
                }
                
                
            }
            else if($action=='repprove'){
                if($should_delete=='yes'){
                    $delete = DB::delete('delete from tb_reqs where id=?', array($id));
                    if($delete){
                        (new PetsController)->sendMail($data[0]->email, 'deleted_req', $justify, date('d/m/Y H:i:s', $data[0]->date));
                        session(['request_info'=>'deleted']);
                        return redirect('/institucional/requisicoes');
                    }
                }else if($should_delete!='yes'){
                    $update = DB::update('update tb_reqs set status=? where id=?', array('refused', $id));
                    if($update){
                        (new PetsController)->sendMail($data[0]->email, 'refused_req', $justify, date('d/m/Y H:i:s', $data[0]->date));
                        session(['request_info'=>'denied']);
                        return redirect('/institucional/requisicoes');
                    }
                }
                
            }       

        }else{
            return view('collect_req_justify')->with('info', 'wrong_justify')->with('op_type', $action)
            ->with('datetime', $datetimestamp)->with('id', $id);
        }

        return view('error_404');
    }

    public function sendMail($send_to, $subject, $justify, $req_time){
        
        $msg = "";
        
        if($subject=='approved_req'){
            $subject = "Agendamento aprovado.";
            $msg = "<p>Seu agendamento realizado para $req_time, foi aprovado pela instituição.


            Em caso de cancelamento ou alteração, entre em contato por este e-mail ou por telefone. </p>";
        }
        else if($subject=="refused_req"){
            $subject = "Agendamento recusado.";
            $msg = "<p>Seu agendamento realizado para $req_time, foi reprovado pela instituição.
            Pelo seguinte motivo: \" $justify \"
            
            Em caso de solicitação de revisão ou alteração do agendamento, entre em contato por este e-mail ou por telefone.</p>";
        }
        else if($subject=="deleted_req"){
            $subject = "Agendamento recusado e excluído.";
            $msg = "<p>Seu agendamento realizado para $req_time, foi excluído e reprovado pela instituição.
            Pelo seguinte motivo: \" $justify \"
            
            Em caso de solicitação de revisão ou alteração do agendamento, entre em contato por este e-mail ou por telefone.</p>";
        }
        else if($subject=='changed_req'){
            $subject = "Agendamento alterado e aprovado.";
            $msg = "<p>Seu agendamento realizado para $req_time, foi aprovado, porém alterado pela instituição.
            Com o seguinte motivo: \" $justify \"
            
            Em caso de solicitação de revisão ou alteração do agendamento, entre em contato por este e-mail ou por telefone.</p>";
        }

        Mail::send('mail.default',
            ['msg' => $msg],
            function($message) use ($send_to, $subject) {
                $message->to(array($send_to))
                ->subject($subject);
            }
        );

    }










    //Operations to app (ajax) and webserver requests:
    public function listPets_app(){

        $pets = DB::select('select * from tb_pets');
        
        return json_encode($pets);
    }

    public function inspectPet_app(Request $request){
        $id=$request->route('id');
        $pet = DB::select('select * from tb_pets where id=?', array($id));

        
        return json_encode($pet);;
    }



    //Dump returns - app requests
    public function listPets_app_dump(){

        $pets = DB::select('select * from tb_pets');
        
        dd($pets);
    }

    public function inspectPet_app_dump(Request $request){
        $id=$request->route('id');
        $pet = DB::select('select * from tb_pets where id=?', array($id));

        dd($pet);
        
    }

    
    
}
