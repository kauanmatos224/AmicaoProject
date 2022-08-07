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
            'txtFantasyName' => 'required|max:30 ',
            'txtCnpj' =>'required|max:20',
            'txtPhone' => 'required|max:20',
            'txtAddress' => 'required|max:100',
            'txtCountry' => 'required|max:20',
            'txtEmail' => 'email|required',
            'txtCep' => 'required|numeric',
            'txtPassword' => 'required|min:8',
            'txtConfPassword' => 'required|min:8',
            'txtComplement' => 'nullable',
        ];
    }
}
