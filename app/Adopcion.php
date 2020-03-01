<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adopcion extends Model
{
    //Adopcion
    protected $table = 'adopcion';
    protected $fillable = [
        'id',
        'idPersona',
        'nombreMascota',
        'especie',
        'raza',
        'fechaNacimiento',
        'edad',
        'observacion',
        'imagen',
        'estado',
    ];
	
	 protected $casts = [
        'estado' => 'boolean',
    ];
    
    public $timestamps = false;
}
