<?php

//Classe que realiza a validação do formulário de contato.

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'txtnome' => 'required|max:50',
            'txtemail' => 'required|max:50|email',
            'txtmsg' => 'required|max:500'
        ];
    }
}
