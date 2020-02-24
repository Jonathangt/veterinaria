<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    protected $table = 'consultas';
    protected $fillable = [
        'id',
        'idUsuario',
        'idCliente',
        'idMascota',
        'esterilizado',
        'tipoProcedimiento',
        'modoOptencion',
        'peso',
        'observacionConsulta',
        'fechaAtencion',
        'horaAtencion',
        'medicamento',
        'horario',
        'observacionReceta',
        'fechaSgtConsulta',
    ];
    
    public $timestamps = false;
}
