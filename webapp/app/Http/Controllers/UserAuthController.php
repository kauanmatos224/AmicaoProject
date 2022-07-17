<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Controllers\UserAuthController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    public function doLogin(UserLoginRequest $request){
        $user_email = $request->post('txtEmail');
        $user_password = $request->post('txtPassword');


        (new UserAuthController)->execSessionDestroy();
        
        $checkCredentials = DB::select('select * from tb_auth_org where email=? and password=?',
        array($user_email, $user_password));

        if($checkCredentials){
            (new UserAuthController)->createSession($user_email, $user_password);
            
            if(!empty(session('required_view'))){
                
                return view(session('required_view'));
            }
            else{
                return view('home');
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

    }

    public function doLogout(){

        (new UserAuthController)->execSessionDestroy();
        return view('home');
    }


    public function execSessionDestroy(){
        
        session([
            'user_id'=>null,
            'user_type'=>null,
            'user_session'=>null     
        ]);
    
    }
}
