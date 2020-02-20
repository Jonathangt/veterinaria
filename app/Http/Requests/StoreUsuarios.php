<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarios extends FormRequest
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
            'email'=>'unique:users|email'
        ];
    }

    public function messages() {
        return [
                'email.unique' => 'El correo ya se encuentra registrado',
                'email.email' => 'El formato del correo no es correcto'
            ];
    }
}
