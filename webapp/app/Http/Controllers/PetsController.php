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

class PetsController extends Controller
{

    public $info = null;
    public function listPets(){
            
        $pets = DB::select('select * from tb_pets');

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

    public function inspectPet(Request $request){

        $id=$request->route('id');

        $pet = (new PetsController)->select_pet($id);

        return view('alterar_pet')->with('pet', $pet);
    }

    public function deletePet(Request $request){
        $id = $request->post('txtId');
        $foto = DB::select('select img_path from tb_pets where id=?', array($id));
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

        
        if($foto!=null && $foto!=""){

            $timestamp = Carbon::now()->timestamp;
            $filename = hash('sha256', $foto->getClientOriginalName().
                $foto->getSize().$foto->getClientOriginalExtension().$timestamp."30/07/2003").
                ".".$foto->getClientOriginalExtension();

            $foto->storeAs('/', $filename);
            $filepath = storage_path('app/'.$filename);
            $img_path = (new Dropbox_FileUpload)->upload($filepath, '/');
            (new Dropbox_FileDeletion)->delete(((new PetsController)->select_pet($id))[0]->img_path);
            Storage::delete($filepath);

        }else{
            $img_path_from_db = ((new PetsController)->select_pet($id))[0]->img_path;
            $img_path = $img_path_from_db;
        }

        if($nascimento==null){
            $nascimento = ((new PetsController)->select_pet($id))[0]->nascimento;
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
        raca_mae, saude, vacinas_essenciais, porte, genero, img_path, status, nascimento) values(
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )', array($nome, $idade, $raca, $raca_pai, $raca_mae, $saude, $vacinas,
                $porte, $genero, $img_path, $status, $nascimento
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

    







    public function select_pet($id){
        return DB::select('select * from tb_pets where id=?', array($id));
    }


    
    //Operations to app (ajax) and webserver requests:



    public function listPets_app(){

        $pets = DB::select('select * from tb_pets');
        dd(json_encode($pets));
        return json_encode($pets);
    }

    public function inspectPet_app(Request $request){
        $id=$request->route('id');
        $pet = DB::select('select * from tb_pets where id=?', array($id));

        dd(json_encode($pet));   
        return json_encode($pet);;
    }
    
}
