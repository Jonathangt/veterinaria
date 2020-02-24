<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    protected $table = 'personas';
    protected $fillable = [
        'id',
        'idUsuario',
        'nombre',
        'apellidos',
        'cedula',
        'direccion',
        'telefono',
        'celular',
        'email',//solo se registrara cuando lo haga el admin
        'estado',

    ];
    
    public $timestamps = false;
}
