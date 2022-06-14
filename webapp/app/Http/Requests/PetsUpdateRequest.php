<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetsUpdateRequest extends FormRequest
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
            
            'txtCod' => 'nullable',
            'txtNome' => 'required|max:20',
            'txtIdade' => 'required|max:2',
            'txtRaca' => 'required|max:20',
            'txtRacaP' => 'required|max:20',
            'txtRacaM' => 'required|max:20',
            'txtSaude' => 'nullable|max:500',
            'txtVacinas' => 'required',
            'txtPorte' => 'required|max:20',
            'txtGenero' => 'required',
            'inpFoto' => 'nullable',
            'txtStatus' => 'required',
            'txtNascimento' => 'nullable'
        ];
    }
}
