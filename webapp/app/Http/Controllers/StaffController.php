<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApproveAccountRequest;

class StaffController extends Controller
{
    public function getView_RegistrationAnalisys(){

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                $data = (new StaffController)->getRegistrationData();
                //dd($data[1][1][0]->status);
                //dd($data[1]);
                if($data!=null){
                    if(!empty(session('info_register_analisys'))){
                        return view('registration_analisys')->with('data', $data[0])->with('status', $data[1])->with('info', session('info_register_analisys'))->with('user_type', $data[1]);
                    }
                    else{
                        return view('registration_analisys')->with('data', $data[0])->with('status', $data[1])->with('user_type', $data[1]);
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
        
        $data = DB::select('select * from tb_org');
 
        if($data){

            $auth_data = array();
            
            for($i=0; $i<count($data); $i++){
                $id_org = $data[$i]->id;
                $auth_data[$id_org] = DB::select('select status, user_type from tb_auth_org where id_org=?', array($id_org));
                
            }
            
            return array($data, $auth_data);
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

    public function deleteInst(ApproveAccountRequest $request){
        $id = $request->post('_id');
        $timestamp = Carbon::now()->timestamp;
        $deletion_date = $timestamp + 2592000; //a month to complete exclusion
        /*if($id==null || empty($id)){
            return view('error_404');
        }*/

        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
                $inst_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?) or (id_org=? and status=?))', array($id, 'waiting', $id, 'approved', $id, 'reproved'));

                if($inst_data){
                    DB::update('update tb_auth_org set status=?, deletion_date=?, previously_status=? where id_org=?', array('deleted', $deletion_date, $inst_data[0]->status, $id));
                    session(['info_register_analisys'=>'deleted_register']);

                    return redirect('/staff/inst-analise');
                }
                
            }
        }

        return view('error_404');
    }

    public function approveInst(Request $request){
        $id = $request->post('_id');
        
        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){

                $account_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?))', array($id, 'denied', $id, 'waiting'));
            
                if($account_data){
                    DB::update('update tb_auth_org set status=?, previously_status=? where id_org=?', array('approved', $account_data[0]->status, $id));
                    
                    session(['info_register_analisys'=>'approved_register']);

                    return redirect('/staff/inst-analise');
                    
                }
                
            }        
        }

        return view('error_404');
    }

    public function restoreInst(Request $request){
        $id=$request->post('_id');
        $inst_data = DB::select('select * from tb_auth_org where (id_org=? and status=?)', array($id, 'deleted'));



        if((new UserAuthController)->checkSession()){
            if(session('user_type')=='staff'){
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

                    return redirect('/staff/inst-analise');

                }
            }
        }

        return view('error_404');

    }

    public function denyInst(Request $request){
        $id=$request->post('_id');

        $inst_data = DB::select('select * from tb_auth_org where ((id_org=? and status=?) or (id_org=? and status=?))', array($id, 'waiting', $id, 'approved'));


        if($account_data){
            DB::update('update tb_auth_org set status=?, previously_status=? where id_org=?', array('approved', $account_data[0]->status, $id));
            
            session(['info_register_analisys'=>'reproved_register']);

            return redirect('/staff/inst-analise');
            
        }
        else{
            return view('error_404');
        }

    }




    public function justifyRestoreInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'restoreInst');
    }

    public function justifyDeleteInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'deleteInst');
    }

    public function justifyApproveInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'approveInst');
    }

    public function justifyDenyInst(Request $request){
        $id=$request->post('_id');

        return view('collect_justify')->with('id', $id)->with('operation_type', 'denyInst');
    }

}


