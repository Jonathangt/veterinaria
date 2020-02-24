<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donaciones extends Model
{
    protected $table = 'donaciones';
    protected $fillable = [
        'id',
        'idUsuario',
        'recaudacion',
        'lugar',
        'motivo',
        'direccion',
        'email',
        'telefono',
        'celular',
        'fechaInicio',
        'fechaFin',
    ];
    
    public $timestamps = false;
}
