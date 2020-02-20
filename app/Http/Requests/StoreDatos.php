<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDatos extends FormRequest
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
            'cedula'=>'unique:personas|digits_between:10,10|numeric|min:0000000000|max:9999999999',
        ];
    }

    public function messages() {
        return [
                'cedula.unique' => 'El número de cedula ya se encuentra registrado',
                'cedula.numeric' => 'El campo cédula solo acepta números',
                'cedula.min' => 'El campo cédula no tiene un formato correcto',
                'cedula.max' => 'El campo cédula no tiene un formato correcto x2',
               // 'cedula.max' => 'El campo cédula solo acepta números x2',
                'cedula.digits_between' => 'El campo cédula debe de contener 10 digitos',
                
            ];
    }
}
