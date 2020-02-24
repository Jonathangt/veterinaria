<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image\ImageServiceProvider;

class Informacion extends Model
{
    protected $table = 'informacion';
    protected $fillable = [
        'id',
        'idUsuario',
        'tema',
        'capacitador',
        'conoce',
        'imagen',
    ];
    
    public $timestamps = false;

    /*public static function setCaratula($imagen, $actual = false){
        if ($imagen) { //
            if ($actual) {//si al editar ys hay una foto, lo eliminara y al guardar le dara un name ramdom
                Storage::disk('public')->delete("imagenes/informacion/$actual");
            }
            $imagenName = Str::random(20) . '.jpg';
            $foto = Image::make($imagen)->encode('jpg', 90); //la img al guardar se la codifica a jpg con una calidad de 90%
            $foto -> resize (530, 470, function ($constraint) {//se la redimenciona
                $constraint->upsize();
            });
            Storage::disk('public')->put("imagenes/informacion/$imagenName", $foto->stream());//se almacena en el disk public
            return $imagenName;
        }  else{
            return false;
        }
    }*/
}
