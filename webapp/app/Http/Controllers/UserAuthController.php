<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Controllers\UserAuthController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PetsController;
use App\Http\Requests\UserRegister;

class UserAuthController extends Controller
{
    public function doLogin(UserLoginRequest $request){
        $user_email = $request->post('txtEmail');
        $user_password = $request->post('txtPassword');


        (new UserAuthController)->execSessionDestroy();
        
        $checkCredentials = DB::select('select * from tb_auth_org where email=? and password=?',
        array($user_email, $user_password));

        if($checkCredentials){

            if($checkCredentials[0]->status=='waiting'){
                //return redirect()->route('info-cadastro', ['info'=>'waiting']);
                return view('info_inst')->with('info', 'waiting');
            }
            else if($checkCredentials[0]->status=='denied'){
                //return redirect()->route('info-cadastro', ['info'=>'denied']);
                return view('info_inst')->with('info', 'denied');
            }
            else if($checkCredentials[0]->status=='approved'){
                (new UserAuthController)->createSession($user_email, $user_password);
            
                if(!empty(session('required_route'))){

                    $required_route = session('required_route');
                    return redirect()->action([PetsController::class, "$required_route"]);
                }
                else{
                    return redirect('/home');
                }
            }
            
        }
        else{
            return view('login')->with('login_status', 'invalid_credentials');
        }
    }

    public function checkSession(){
        $user_id = session('user_id');
        $user_type = session('user_type');
        $timestamp = Carbon::now()->timestamp;

        $userData = DB::select('select * from tb_auth_org where id=?', array($user_id));

        if($userData){

            $sessionServer = hash('sha256', str($userData[0]->id.$userData[0]->user_type.$userData[0]->email.$userData[0]->logged_at.env('APP_KEY')));
    
            if($sessionServer == session('user_session')){
                
                if(($userData[0]->logged_at + 604800) <= $timestamp){
                    return false;
                }
                else{
                    return true;
                }
            }
        }


        return false;
    }

    public function createSession($user_email, $user_password){

        
        $timestamp = Carbon::now()->timestamp;
        DB::update('update tb_auth_org
            set logged_at=?
            where email=? and password=?
        ', array($timestamp, $user_email, $user_password));

        $userData = DB::select('select * from tb_auth_org where email=? and password=?', array($user_email, $user_password));
    
        $user_session = hash('sha256', str($userData[0]->id.$userData[0]->user_type.$userData[0]->email.$userData[0]->logged_at.env('APP_KEY')));
        session([
            'user_id'=>$userData[0]->id,
            'user_type'=>$userData[0]->user_type,
            'user_session'=>$user_session     
        ]);

        if($userData[0]->user_type =="inst"){
            session(['id_org'=>$userData[0]->id_org]);
        }

    }

    public function doLogout(){

        (new UserAuthController)->execSessionDestroy();
        return view('home');
    }


    public function execSessionDestroy(){
        
        session([
            'user_id'=>null,
            'user_type'=>null,
            'user_session'=>null,
            'id_org'=>null
        ]);
    
    }

    public function execSessionRequiresDestroy(){
        session([
            'required_route'=>null,
        ]);
    }

    public function getView_cadastrar_inst(){
        (new UserAuthController)->execSessionDestroy();
        (new UserAuthController)->execSessionRequiresDestroy();

        return view('cadastrar_inst');
    }

    public function registerInst(UserRegister $request){
        (new UserAuthController)->execSessionDestroy();
        (new UserAuthController)->execSessionRequiresDestroy();

        $nome_fantasia = $request->post('txtFantasyName');
        $cnpj = $request->post('txtCnpj');
        $telefone = $request->post('txtPhone');
        $email = $request->post('txtEmail');
        $endereco = $request->post('txtAddress');
        $complemento = $request->post('txtComplement');
        $country = $request->post('txtCountry');
        $cep = $request->post('txtCep');
        $password = $request->post('txtPassword');
        $password_conf = $request->post('txtConfPassword');

        if($password == $password_conf){

            $checkEquality = DB::select('select * from tb_org where phone=? or
                (endereco=? and complemento=? and cep=?) or cnpj=?', 
                array(
                    $telefone,
                    $endereco,
                    $complemento,
                    $cep,
                    $cnpj,
                )
            );

            if($checkEquality){
                if($checkEquality[0]->phone==$telefone){
                    return view('cadastrar_inst')->with('error', 'matched_phone');
                }
                else if($checkEquality[0]->endereco==$endereco && $checkEquality[0]->complemento==$complemento &&
                $checkEquality[0]->cep==$cep){
                    return view('cadastrar_inst')->with('error', 'matched_address');
                }
                else if($checkEquality[0]->cnpj==$cnpj){
                    return view('cadastrar_inst')->with('error', 'matched_cnpj');
                }
            }
            else{

                $checkEquality = DB::select('select * from tb_auth_org where email=?', array($email));
                if($checkEquality){
                    return view('cadastrar_inst')->with('error', 'matched_email');
                }
                else{
                    DB::insert('insert into tb_org(
                        nome_fantasia,
                        cep,
                        endereco,
                        complemento,
                        country,
                        phone,
                        cnpj
    
                    )
                    
                    values(
                        ?, ?, ?, ?, ?, ?, ?
                    )', array(
                            $nome_fantasia,
                            $cep,
                            $endereco,
                            $complemento,
                            $country,
                            $telefone,
                            $cnpj
                        )
                    );
    
                    $select_org = DB::select('select id from tb_org where cnpj=?', array($cnpj));
                    $id_org = $select_org[0]->id;
    
                    DB::insert('insert into tb_auth_org(
                            id_org,
                            email,
                            password,
                            user_type,
                            status
                        )
                    
                        values(
                            ?, ?, ?, ?, ?
                        )', array($id_org, $email, $password, "inst", "waiting")
                    );
    
                    return view('req_cadastro_enviada');
                }
            
            }

            
        }else{
            return view('cadastrar_inst')->with('error', 'password-confirmation');
        }

    }

    public function reoveryPassword(RecoveryPassRequest $request){

        $email = $request->post('txtEmail');
        $checkEmail = DB::select('select * from tb_auth_org where email=?', array($email));

        if($checkEmail){
            
            $random = rand(1,10000);
            $secret = "30/07/2003";
            $timestamp = Carbon::now()->timestamp;
            $instData = DB::select('select cnpj,id from tb_org where cnpj=?', array($cnpj));
            $token = hash('sha256', $checkEmail[0]->email.$instData[0]->cnpj.$random.$secret.$timestamp);

            DB::insert('insert into tb_user_rec_pass (id_org, tmp_token, generated_at)
                values(?, ?, ?)', array($instData[0]->id, $token, $timestamp));
            
            $url = env('APP_URL')."/institucional/rec-password/reset/".$token;

            //Must to send e-mail
        }


    }

    public function getView_set_restet_password(Request $request){
        $token = $request->route('token');
        $timestamp = Carbon::now()->timestamp;

        $checkToken = DB::select('select * from tb_user_rec_pass where tmp_token=? and generated_at < ?',
            array($token, $timestamp));
        
        if($checkToken){
            DB::update('update tb_user_rec_pass set start_reset_at=? where tmp_token=?', 
                array($timestamp, $token));
            
                return view('set_reset_password')->with('tmp_token', $token);

        }
        else{
            return view('error_404');
        }

        
    }

    public function setNewPassword(setNewPasswordRequest $request){
        $password = $request->post('txtPassword');
        $password_conf = $request->post('txtConfPassword');
        $token = $request->post('tmp_token');

        if($password==$password_conf){
            if(!$token==null){
                $related_id = DB::select('select id_org from tb_user_rec_pass where token=?', array($token));

                if($related_id){
                    DB::update('update tb_auth_org set password=? where id_org=? ', array($password, $related_id[0]->id_org));
                    DB::delete('delete from tb_user_rec_pass where tmp_token=?', array($token));
                    return view('info_inst')->with('info', 'changed_password');
                }
            }

            return view('info_inst')->with('info', 'forged_csrf');
            
        }
        else{
            return view('set_reset_password')
                ->with('tmp_token', $token)
                ->with('error', 'not_matched_password');
        }
    }


 
}
