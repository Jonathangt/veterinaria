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
        'telefono',
        'celular',

    ];
    
    public $timestamps = false;
}
