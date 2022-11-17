<?php

//Classe que realiza (contém as regras e tratamentos) validação de valores 
//recebidos do formulário de cadastro de instituição  
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'txtFantasyName' => 'required|max:30 ',
            'txtCnpj' =>'required|max:20',
            'txtPhone' => 'required|max:20',
            'txtAddress' => 'required|max:100',
            'txtCountry' => 'required|max:20',
            'txtEmail' => 'email|required|max:100',
            'txtCep' => 'required|numeric|max:9',
            'txtPassword' => 'required|min:8',
            'txtConfPassword' => 'required|min:8',
            'txtComplement' => 'nullable|max:100',
        ];
    }
}
