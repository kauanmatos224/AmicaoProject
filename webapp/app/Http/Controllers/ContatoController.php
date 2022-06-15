<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContatoRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RequestStack;

class ContatoController extends Controller
{
    public function sendMessage(ContatoRequest $request){
        
        $fullname = $request->post('txtnome');
        $email = $request->post('txtemail');
        $message = $request->post('txtmsg');

        $insert = DB::insert('insert into tb_users_faq(
            fullname, email, message, solicitation_status
        )
        values(
            ?, ?, ?, ?
        )', array($fullname, $email, $message, 'not_solved'));

        if($insert){
            $status = "sucess";
        }
        else{
            $status = "fail";
        }

        return view('contato.msg-sent')->with('status', $status);
    }
}
