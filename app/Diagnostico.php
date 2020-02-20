<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnostico';
    protected $fillable = [
        'id',
        'idUsuario',
        'idPersona',
        'esterilizado',
        'tipoProcedimiento',
        'modoOptencion',
        'observacionDiagnostico',
        'fechaAtencion',
        'horaAtencion',
        'medicamento',
        'horario',
        'observacionReceta',
    ];
    
    public $timestamps = false;
}
