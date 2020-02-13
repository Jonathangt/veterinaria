<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mascotas extends Model
{
    protected $table = 'mascotas';
    protected $fillable = [
        'id',
        'idUsuario',
        'idPersona',
        'nombreMacota',
        'especie',
        'raza',
        'fechaNacimiento',
        'edad',

    ];
    
    public $timestamps = false;
}
