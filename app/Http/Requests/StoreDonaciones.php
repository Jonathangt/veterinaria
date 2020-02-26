<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonaciones extends FormRequest
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
          //  'recaudacion' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
          //  'lugar' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
          //  'motivo' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'telefono'=>'numeric|digits_between:7,10',
            'direccion' =>'regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'email'=> 'email',
        ];
    }

    public function messages() {
        return [
             //   'recaudacion.regex' => 'Este campo no permite caracteries especiales',
            //    'lugar.regex' => 'Este campo no permite caracteries especiales',
            //    'motivo.regex' => 'Este campo no permite caracteries especiales',
                'telefono.numeric' => 'Este campo solo acepta números',
                'telefono.digits_between' => 'Este campo debe tener minimo siete digitos',
                'direccion.regex' => 'Este campo no permite caracteries especiales',
                'email.email' => 'El formato del correo no es correcto',    
            ];
    }
}
