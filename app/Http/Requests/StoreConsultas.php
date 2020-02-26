<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultas extends FormRequest
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
            'peso' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'observacionDiagnostico' =>'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'medicamento' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'horario' => 'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'observacionReceta' =>'regex:/^[A-ZÀÂÇÉÈÊËÎÏÔÛÙÜŸÑÆŒa-zàâçéèêëîïôûùüÿñæœ0-9_.,() ]+$/',
            'fechaSgtConsulta' =>'after:now',
    
        ];
    }

    public function messages() {
        return [
                'peso.regex' => 'Este campo no permite caracteries especiales',
                'observacionDiagnostico.regex' => 'Este campo no permite caracteries especiales',
                'medicamento.regex' => 'Este campo no permite caracteries especiales',
                'horario.regex' => 'Este campo no permite caracteries especiales',
                'observacionReceta.regex' => 'Este campo no permite caracteries especiales',
                'fechaSgtConsulta.after' => 'La siguiente consulta no puede ser antes de la fecha actual',

            ];
    }
}
