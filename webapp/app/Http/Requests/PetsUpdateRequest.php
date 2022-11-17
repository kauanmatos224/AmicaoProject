<?php

//Classe que realiza a validação do formulário de atualização de informações do pet
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
            'txtRacaP' => 'max:20',
            'txtRacaM' => 'max:20',
            'txtSaude' => 'nullable|max:500',
            'txtVacinas' => 'required',
            'txtPorte' => 'required|max:20',
            'txtGenero' => 'required',
            'inpFoto' => 'nullable',
            'txtStatus' => 'required',
            'txtNascimento' => 'nullable'
        ];
    }

    public function messages(){
        return [
            'txtNome.required' => 'O nome do pet é obrigatório',
            'txtIdade.required' => 'A idade do pet é obrigatória',
            'txtRaca.required' => 'A raça do animal é obrigatória',
            'txtRacaP.max' => 'Máximo de 20 caracteres excedido sobre a raça do pai',
            'txtRacaM.max' => 'Máximo de 20 caracteres excedido sobre a raça da mãe',
            'txtSaude.max' => 'Máximo de 500 caracteres excedido sobre a saúde do pet',
            'txtVacinas.required' => 'A informação sobre as vacinas é obrigatória',
            'txtPorte.required' => 'O porte do pet é obrigatório',
            'txtGenero.required' => 'O genero do pet é obrigatório',
            'txtStatus.required' => 'O status do pet é obrigatório'
        ];
    }
}
