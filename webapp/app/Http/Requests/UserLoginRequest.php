<?php
//Classe que realiza a validação dos valores de entrada do formulário de login (email e senha) 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'txtEmail' => 'required|email',
            'txtPassword' => 'required',
        ];
    }
}
