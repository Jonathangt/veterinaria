<?php

namespace App\Http\Controllers;
use App\User;
use App\Informacion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InformacionController extends Controller
{
    
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $informacion = Informacion::join('users', 'informacion.idUsuario', 'users.id')
                                        ->select( 'informacion.id', 'informacion.idUsuario', 'informacion.tema',
                                                     'informacion.capacitador', 'informacion.conoce', 'informacion.imagen',
                                                     'users.name')
                                        ->orderBy('informacion.id', 'desc')->paginate(10);

        }
        else{
            $informacion =  Informacion::join('users', 'informacion.idUsuario', 'users.id')
                                    ->select( 'informacion.id', 'informacion.idUsuario', 'informacion.tema',
                                                'informacion.capacitador', 'informacion.conoce', 'informacion.imagen',
                                                'users.name')
                                        ->where($criterio, 'like', '%'. $buscar . '%')
                                        ->orderBy('informacion.id', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $informacion->total(),
                'current_page' => $informacion->currentPage(),
                'per_page'     => $informacion->perPage(),
                'last_page'    => $informacion->lastPage(),
                'from'         => $informacion->firstItem(),
                'to'           => $informacion->lastItem(),
            ],
            'informacion' => $informacion
        ];
    }


    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();
            //$path = Storage::disk('public')->put('informacion', $request->file('imagenMiniatura'));
           // $post ->fill(['imagenMiniatura' => asset($path)]);


            $exploded = explode(',', $request->imagenMiniatura);
            $decode = base64_decode($exploded[1]);
            $imagenName = Str::random(20) . '.jpg';
            //$path = public_path().'/'.'informacion/'.$imagenName;
            $path = public_path().'/informacion/'.$imagenName;
            file_put_contents($path, $decode);

            $informacion = new Informacion();
            $informacion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $informacion->tema = $request->tema;
            $informacion->capacitador = $request->capacitador;
            $informacion->conoce = $request->conoce;
            $informacion->imagen = $imagenName;
            $informacion->save();
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
                
            $informacion = Informacion::findOrFail($request->id);

            

            $exploded = explode(',', $request->imagenMiniatura);
            $decode = base64_decode($exploded[1]);
            $imagenName = Str::random(20) . '.jpg';
            //$path = public_path().'/'.'informacion/'.$imagenName;
            $path = public_path().'/informacion/'.$imagenName;
            file_put_contents($path, $decode);
            

            $informacion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $informacion->tema = $request->tema;
            $informacion->capacitador = $request->capacitador;
            $informacion->conoce = $request->conoce;
            $informacion->imagen = $imagenName;
            $informacion->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
        //if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $informacion = Informacion::join('users', 'informacion.idUsuario', 'users.id')
                                    ->select( 'informacion.id', 'informacion.idUsuario', 'informacion.tema', 'informacion.capacitador',
                                                'informacion.conoce', 'informacion.imagen', 'users.name')
                                ->where('Informacion.id','=',$id)->get();
        return ['informacion' => $informacion];
    }

    public function informacionMostrar(Request $request)    {//metodo para mostrar la info a los usuarios
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
      
        $informacion = Informacion::orderBy('informacion.id', 'desc')->paginate(5);


        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $informacion->total(),
                'current_page' => $informacion->currentPage(),
                'per_page'     => $informacion->perPage(),
                'last_page'    => $informacion->lastPage(),
                'from'         => $informacion->firstItem(),
                'to'           => $informacion->lastItem(),
            ],
            'informacion' => $informacion
        ];
    }


    public function destroy($id)  {
        $informacion = Informacion::findOrFail($id)->delete();
    } 

}
