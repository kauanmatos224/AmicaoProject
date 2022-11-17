<?php

//Controller responsável por executar ações relacioandas ao fluxo de FAQ / Contato.

//Define o escopo de acesso da classe (segurança
namespace App\Http\Controllers;

//Importa as classes necessárias para performar as operações nos métodos seguintes.
use Illuminate\Http\Request;
use App\Http\Requests\ContatoRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RequestStack;


//Inicializa a classe extendendo a classe Controller (herança)
class ContatoController extends Controller
{

    //Função responsável por salvar a mensagem do usuário do formulário de contato no banco de dados.
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


    //Método que retorna a view / página de contato com mensagem de solicitação para reativação de conta desativada.
    public function getViewContato_account_activation(Request $request){
        $email = $request->post('txtEmail');
        return view('contato')->with('info', 'account_activation_request')->with('email', $email);
    }
}
