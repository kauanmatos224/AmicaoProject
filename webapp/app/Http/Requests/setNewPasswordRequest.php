<?php

//Classe que realiza validação dos formulário de redefinição de senha.
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class setNewPasswordRequest extends FormRequest
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
            'txtPassword' => 'required|min:8',
            'txtConfPassword' => 'required|min:8',
        ];
    }
}
