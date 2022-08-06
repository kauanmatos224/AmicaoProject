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
                if($this->info!=null && $this->info!=""){
                    return view('pets')->with('pets', $pets)->with('info', $this->info);    
                }else{
                    return view('pets')->with('pets', $pets);//->with('info', $info);
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
            
            
            $id = $request->post('txtId');
            $foto = DB::select('select img_path from tb_pets where id=? and id_org=?',
                array($id, session('id_org')));
            
            if($foto){
            
                $delete = DB::delete('delete from tb_pets where id=?', array($id));

                $this->info = "";
                if($delete){

                    if((new Dropbox_FileDeletion)->delete($foto[0]->img_path)){
                        $this->info="deleted_pet";
                    }
                    else{
                        $this->info="error_delete_pet";    
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
                return view('requisicoes')->with('user_type', session('user_type'));
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
