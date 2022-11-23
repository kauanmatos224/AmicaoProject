<?php

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
            'txtFantasyName' => 'required|max:55 ',
            'txtCnpj' =>'required|max:20',
            'txtPhone' => 'required|max:20',
            'txtAddress' => 'required|max:100',
            'txtCountry' => 'required|max:20',
            'txtEmail' => 'email|required',
            'txtCep' => 'required|numeric|max:9',
            'txtPassword' => 'required|min:8|max:100',
            'txtConfPassword' => 'required|min:8|max:100',
            'txtComplement' => 'nullable',

        ];
    }

    public function messages(){
        return [
            'txtFantasyName.required' => 'O Nome Fantasia é obrigatório.',
            'txtCnpj.required'=> 'O CNPJ é obrigatório.',
            'txtPhone.required' => 'O telefone é obrigatório.',
            'txtAddress.required' => 'O endereço é obrigatório.',
            'txtCountry.required' => 'O páis é obrigatório.',
            'txtEmail.email' => 'Um formato válido de e-mail deve ser informado.',
            'txtCep.required' => 'O Código Postal é obrigatório.',
            'txtPassword.required' => 'Uma senha é necessária para estabelecer a sua autenticação.',
            'txtConfPassword.required' => 'A confirmação da senha é obrigatória.',
            'txtFantasyName.max:55' => 'O Nome Fantasia não pode exceder 55 caracteres.',
            'txtCnpj.max' => 'O CNPJ ou equivalente não pode exceder 20 caracteres.',
            'txtPhone.max' => 'O telefone não pode ultrapassar 20 carateres contando com código de páis e estado.',
            'txtAddress.max' => 'O endereço não pode ultrapassar 100 caracteres.',
            'txtCountry.max' => 'O páis não pode exceder 20 caracteres.',
            'txtEmail.required' => 'O e-mail é obrigatório.',
            'txtCep.numeric' => 'O Código Postal deve ser no formato numérico.',
            'txtPassword.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'txtPassword.max' => 'A senha não pode exceder 100 caracteres.',
            'txtConfPassword.min' => '',
            'txtConfPassword.max' => '',
            'txtCep.max' => 'O código Postal não pode ultrapassar 9 dígitos.'

        ];
    }
}
