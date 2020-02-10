<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mascotas extends Model
{
    protected $table = 'mascotas';
    protected $fillable = [
        'id',
        'idUPersona',
        'nombreMacota',
        'especie',
        'raza',
        'fechaNacimiento',
        'edad',
        'observacion',
        'imagen',

    ];
    
    public $timestamps = false;
}
