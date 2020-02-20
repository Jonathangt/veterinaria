<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personas;
use App\User;
use App\Mascotas;
use Illuminate\Support\Facades\DB;



class PersonasController extends Controller
{
    public function index(Request $request)    {
        //if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = Personas::join('users', 'personas.idUsuario', 'users.id')
                            ->select('users.email', 'personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                    'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular')
                            ->orderBy('personas.id', 'desc')->paginate(10);
        }
        else{
            $personas =  Personas::join('users', 'personas.idUsuario', 'users.id')
                        ->select('users.email', 'personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular')
                            ->where($criterio, 'like', '%'. $buscar . '%')
                            ->orderBy('personas.nombre', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function obtenerID(Request $request){
        //metodo para obtener el periodo lectivo de la malla registrada
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $obtenerID = User::join('users', 'personas.idUsuario', 'users.id')
                            ->select('id', 'name')
                                ->where('id','=',$id)->get(); //take para que solo obtenga un registro
        return ['obtenerID' => $obtenerID];
    }

    


    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();
        
            
            $personas = new Personas();
            $personas->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $personas->nombre = $request->nombre;
            $personas->apellidos = $request->apellidos;
            $personas->cedula = $request->cedula;
            $personas->direccion = $request->direccion;
            $personas->telefono = $request->telefono;
            $personas->celular = $request->celular;

            $personas->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function destroy($id)  {
        $personas = Personas::findOrFail($id)->delete();
    } 

  
}
