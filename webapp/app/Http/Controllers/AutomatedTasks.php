<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutomatedTasks extends Controller
{
    public function completeAccountDeletion(Request $request){
        $timestamp = $timestamp = Carbon::now()->timestamp;
        $alltime_less_two_chars = substr($timestamp, 0, count($timestamp)-3);
        $time_secret = ((intval($alltime_less_two_chars))*3)/2;
        $server_secret = hash('sha256', '30/07/2003'.'07/30/2003'.'amicaooacima'.$time_secret);
        $request_key = $request->post('key');
        
        
        if($request_key==$server_secret){
            $accounts_data = DB::select('select id_org, deletion_date from tb_auth_org where status=?', array('deleted'));

            if($accounts_data){
                foreach($accounts_data as $data){
                    if($data->deletion_date < $timestamp){
                        DB::delete('delete from tb_org where id=?', array($data->id_org));
                        DB::delete('delete from tb_auth_org where id_org=?', array($data->id_org));
                    }
                    
                }
            }
        }
    }
}
