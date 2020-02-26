<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMascotas extends FormRequest
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
            'nombreMascota'=>'regex:/^[\pL\s]+$/u',
            'especie'=>'regex:/^[\pL\s]+$/u',
            'raza'=>'regex:/^[\pL\s]+$/u',
            'edad' =>'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',  
        ];
    }

    public function messages() {
        return [
                'nombreMascota.regex' => 'Este campo solo acepta letras',
                'especie.regex' => 'Este campo solo acepta letras',
                'raza.regex' => 'Este campo solo acepta letras',
                'edad.regex' => 'Este campo no permite caracteries especiales',

            ];
    }
}
