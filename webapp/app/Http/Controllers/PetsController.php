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
            
                                    if($foto[0]->img_path!="/no-photo.png"){
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
                        if($pet_data[0]->img_path!="/no-photo.png" && $pet_data[0]->img_path!="no-photo.png"){
                            (new Dropbox_FileDeletion)->delete(($pet_data)[0]->img_path);
                        }
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


        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst'){

                $data = DB::select('select * from tb_reqs where id=?', array($id));

                if($data){
                    return view('inspect_req')->with('data', $data[0]);
                }
            }
        }
        else{
            session(['required_route'=>'getView_requisicoes']);
            return view('login');
        }

        return view('error_404');

    }

    public function reqAction(Request $request){
        $id = $request->post('_id');
        $action = $request->post('op_type');

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst'){

                if($id!=null && $action!=null && ($action=='change' || $action=='repprove' || $action=='approve')){
                    if($action=='approve'){
                        $data = DB::select('select req_type, email, date from tb_reqs where id=?', array($id));
                        $approve = DB::update('update tb_reqs set status=? where (id=? and status=?) or (id=? and status=?)', array('acceptted', $id, 'not_seen', $id, 'refused'));
                        if($approve){
                            (new PetsController)->sendMail($data[0]->email, 'approved_req','',date('d/m/Y H:i:s', $data[0]->date));
                            session(['request_info'=>'approved']);
                            return redirect('/institucional/requisicoes');
                        }
                    }else{
                        $datetime = DB::select('select date from tb_reqs where id=?', array($id));
                        return view('collect_req_justify')->with('id', $id)->with('op_type', $action)->with('datetime', $datetime[0]->date);
                    }
                }
            }
        }
        else{
            session(['required_route'=>'getView_requisicoes']);
            return view('login');
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

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='inst'){
    
                if($justify!=null && $justify!=""){

                    $data = DB::select('select * from tb_reqs where id=?', array($id));
                    if($action=='change'){
                        if($date_status=='changed'){
                            if($validate_date=='01/01/1970 00:00:00'){
                                return view('collect_req_justify')->with('info', 'wrong_date')->with('op_type', $action)
                                ->with('datetime', $datetimestamp)->with('id', $id);
                            }else{
                                $date_to_database = strtotime($datetime);
                                $update = DB::update('update tb_reqs set status=?, date=? where (id=? and status=?) or (id=? and status=?)', array('acceptted', $date_to_database, $id, 'refused', $id, 'not_seen'));

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
                            $update = DB::update('update tb_reqs set status=? where (id=? and status!=?)', array('refused', $id, 'refused'));
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
            }
        }
        else{
            session(['required_route'=>'getView_requisicoes']);
            return view('login');
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

    public function requestRegister(Request $request){
        $nome = $request->post('nome');
        $email = $request->post('email');
        $datetime_timestamp = $request->post('datetime');
        $request_type = $request->post('request_type');
        $phone = $request->post('phone');
        $pet_id = $request->post('pet_id');
        $obs = $request->post('req_obs');

        $status='not_seen';

        $insert = DB::insert('insert into tb_reqs(nome, email, phone, status, date, req_type, id_pet, obs) values(?, ?, ?, ?, ?, ?, ?, ?)', array(
            $nome, $email, $phone, $status, $datetime_timestamp, $request_type, $pet_id, $obs
        ));

        if($insert){
            $response = "{\"op_status\":\"sucess\"}";
            return json_encode($response);
        }else{
            $response = "{\"op_status\":\"error\"}";
        }

        
        return json_encode($response);

    }


    public function listPets_app(){
    
        $pets = DB::select('select tb_pets.*, tb_org.endereco from tb_pets inner join tb_org on tb_org.id=tb_pets.id_org');

        for($i=0;$i<count($pets);$i++){
            $img_path = $pets[$i]->img_path;
            $img_link = (new Dropbox_AccessFile)->getTemporaryLink($img_path);
            $pets[$i]->img_path=$img_link;
        }
        
        return json_encode($pets);

    }


    public function inspectPet_app(Request $request){
        $id=$request->route('id');
        $pet = DB::select('select tb_pets.*, tb_org.endereco from tb_pets inner join tb_org on tb_org.id=tb_pets.id_org and tb_pets.id=?', array($id));
        
        $img_path = $pet[0]->img_path;
        $img_link = (new Dropbox_AccessFile)->getTemporaryLink($img_path);
        $pet[0]->img_path=$img_link;
    
        return json_encode($pet);
    }



    //Dump returns - app requests
    public function listPets_app_dump(){

        $pets = DB::select('select tb_pets.*, tb_org.endereco from tb_pets inner join tb_org on tb_org.id=tb_pets.id_org');

        for($i=0;$i<count($pets);$i++){
            $img_path = $pets[$i]->img_path;
            $img_link = (new Dropbox_AccessFile)->getTemporaryLink($img_path);
            $pets[$i]->img_path=$img_link;
        }

        dd(json_encode($pets));
    }

    public function inspectPet_app_dump(Request $request){
        $id=$request->route('id');
        $pet = DB::select('select tb_pets.*, tb_org.endereco from tb_pets inner join tb_org on tb_org.id=tb_pets.id_org and tb_pets.id=?', array($id));
        
        $img_path = $pet[0]->img_path;
        $img_link = (new Dropbox_AccessFile)->getTemporaryLink($img_path);
        $pet[0]->img_path=$img_link;
    

        dd(json_encode($pet));
        
    }

    public function dumpPOST_body(){
        dd("Dump de corpo da requisição POST para envio de agendamentos dos usuário para a aplicação pela API de link: /application_send/send_request"."\n".
            "Parametros de corpo:"."\n"."[nome]"."\n"."[email]"."\n"."[datetime]"."\n"."[request_type]"."\n"."[phone]"
            ."\n"."[pet_id]"."\n"."[req_obs]"."\n"."***Ignorar as quebras de linha \"\\n\"");

    }

    public function count_pets_data(){
        $select = DB::select('select count(*) from tb_pets');
        return json_encode($select[0]);
    }

    public function count_pets_data_dump(){
        $select = DB::select('select count(*) from tb_pets');
        dd(json_encode($select[0]));

    }

    
    public function registerRequest(Request $request){
        $id_pet = intval($request->post('id_pet'));
        $datetime = $request->post('datetime');
        $nome = $request->post('nome');
        $phone = $request->post('phone');
        $email = $request->post('email');
        $status = "not_seen";
        $req_type = $request->post('req_type');
        $obs = $request->post('obs');

        $timestamp = null;
        if(strtotime($datetime)){
            $timestamp = strtotime($datetime);
        }
        else{
            return json_encode(["error"=>"invalid_date"]);
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
            return json_encode(["error"=>"invalid_email"]);
        }

        if(strlen(str($phone))<11 || !intval($phone)){
            return json_encode(["error"=>"invalid_phone"]);
        }

        if(!preg_match ("/^[a-zA-z]*$/", $nome)){
            return json_encode(["error"=>"invalid_name"]);
        }
        
        if($req_type!="adocao" && $req_type!="visita" && $req_type!="apadrinhamento"){
            return json_encode(["error"=>"invalid_request_type"]);
        }

        
        try{
            DB::insert('insert into tb_reqs(id_pet, nome, phone, email, obs, status, req_type, date) values(?, ?, ?, ?, ?, ?, ?, ?)', array(
                $id_pet,
                $nome,
                $phone,
                $email,
                $obs,
                $status,
                $req_type,
                $timestamp
            ));
        }catch(\Illuminate\Database\QueryException $ex){
            return json_encode(["error"=>"invalid_id"]);
        }

        $data = DB::select('select tb_pets.*, tb_org.endereco from tb_pets inner join tb_org on tb_org.id=tb_pets.id_org and tb_pets.id=?', array($id_pet));
        (new PetsController)->sendMail_infoPet($email, "pets_info", $data, $req_type);

        return json_encode(["success"=>"request_sent"]);
    }

    public function sendMail_infoPet($send_to, $subject, $data, $op_type){
        
        $msg = "";
        
        if($subject=='pets_info'){

            $info = "
                    Parabens seu agendamento pelo <strong>app</strong> foi realizado com sucesso, a instituição do animal irá avaliar 
                    a possibilidade do agendamente e entrará em contato em breve. 
                    <br>
                    Abaixo segue maiores detalhes do Pet pretentido:
                    <br>
                    <ul>".
                    "<li>Foto: ".(($data[0]->img_path=="/no-photo.png")? "a instituição não forneceu foto do pet" : "<img src=\"".((new Dropbox_AccessFile)->getTemporaryLink($data[0]->img_path))."\">")."</li>".
                    "<li>Nome: ".$data[0]->nome."</li>".
                    "<li>Raca: ".$data[0]->raca."</li>".
                    "<li>Raca do Pai: ".(($data[0]->raca_pai!=null && $data[0]->raca_pai!="")? $data[0]->raca_pai."</li>" : "Não informado"."</li>").
                    "<li>Raca da mãe: ".(($data[0]->raca_mae!=null && $data[0]->raca_mae!="")? $data[0]->raca_mae."</li>" : "Não informado"."</li>").
                    "<li>Nascimento: ".(($data[0]->nascimento!=null && $data[0]->nascimento!="")? date('d/m/Y', strtotime($data[0]->nascimento))."</li>" : "Não informado"."</li>").
                    "<li>Idade: ".(($data[0]->idade!=null && $data[0]->idade!="")? $data[0]->idade."</li>" : "Não informado"."</li>").
                    "<li>Status: ".(($data[0]->status!=null && $data[0]->idade=="em_adocao")? "em adoção"."</li>" : $data[0]->status."</li>").
                    "<li>Comportamento: ".(($data[0]->comportamento!=null && $data[0]->comportamento!="")? $data[0]->comportamento."</li>" : "Não informado"."</li>").
                    "<li>Genero: ".(($data[0]->genero!=null && $data[0]->genero!="")? $data[0]->genero."</li>" : "Não informado"."</li>").
                    "<li>Porte: ".(($data[0]->porte!=null && $data[0]->porte!="")? $data[0]->porte."</li>" : "Não informado"."</li>").
                    "<li>Vacinas essenciais: ".(($data[0]->vacinas_essenciais!=null && $data[0]->vacinas_essenciais!="")? $data[0]->vacinas_essenciais."</li>" : "Não informado"."</li>").
                    "<li>Saúde: ".(($data[0]->saude!=null && $data[0]->saude!="")? $data[0]->saude."</li>" : "Não informado"."</li>").
                    "<li>Endereço: ".$data[0]->endereco."</li>".
                    "</ul>";

            $subject = "Sobre a $op_type do Pet";
            $msg = "<h2>Segue as informações do pet:</h2>".$info;
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

