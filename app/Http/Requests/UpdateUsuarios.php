<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarios extends FormRequest
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
        return [//es unico y se valida en la tabla users en el campo email
            'email' => 'required|email|unique:users,email,'.$this->user()->id  
        ];
    }

    public function messages() {
        return [
                'email.unique' => 'El correo ya se encuentra registrado',
                'email.email' => 'El formato del correo no es correcto'
            ];
    }
}
