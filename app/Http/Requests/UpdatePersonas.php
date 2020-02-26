<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Personas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UpdatePersonas extends FormRequest
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
    public function rules(Request $request){
       
       
        $persona = Personas::findOrFail($request->id);
      
        return [

            'cedula' => [
                'numeric',
                'digits_between:10,10',
                Rule::unique('personas')->ignore($persona->id),
            ],

            'email' => [
                'email',
                Rule::unique('personas')->ignore($request->id),
            ],

            'telefono'=>'numeric|digits_between:7,10',
            'celular'=>'numeric|digits_between:10,10',
            'nombre'=>'regex:/^[\pL\s]+$/u',
            'apellidos'=>'regex:/^[\pL\s]+$/u',
            'direccion' =>'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            
        ];
       
    }

    public function messages() {
        return [
                'email.unique' => 'El correo ya se encuentra registrado',
                'email.email' => 'El formato del correo no es correcto',

                'cedula.unique' => 'El número de cédula ya se encuentra registrado',
                'cedula.numeric' => 'Este campo solo acepta números',
                'cedula.digits_between' => 'Este campo debe tener diez digitos',

                'telefono.numeric' => 'Este campo solo acepta números',
                'telefono.digits_between' => 'Este campo debe tener minimo siete digitos',

                'celular.numeric' => 'Este campo solo acepta números',
                'celular.digits_between' => 'Este campo debe tener diez digitos',

                'nombre.regex' => 'Este campo solo acepta letras',
                'apellidos.regex' => 'Este campo solo acepta letras',

                'direccion.regex' => 'Este campo no permite caracteries especiales',


            ];
    }
}
