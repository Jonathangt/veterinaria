<?php

namespace App\Http\Controllers;
use App\Mascotas;
use App\Personas;
use Illuminate\Http\Request;

class MascotasController extends Controller
{
    public function index(Request $request)    {
        //if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $mascotas = Mascotas::join('personas', 'mascotas.idPersona', 'personas.id')
                                    ->join('users', 'mascotas.idUsuario', 'users.id')
                                   ->select('mascotas.id', 'mascotas.idPersona', 'mascotas.nombreMacota', 'mascotas.especie',
                                            'mascotas.raza', 'mascotas.fechaNacimiento', 'mascotas.edad', 'mascotas.sexo', 'users.name')
                                    ->orderBy('mascotas.id', 'desc')->paginate(10);
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
                'total'        => $mascotas->total(),
                'current_page' => $mascotas->currentPage(),
                'per_page'     => $mascotas->perPage(),
                'last_page'    => $mascotas->lastPage(),
                'from'         => $mascotas->firstItem(),
                'to'           => $mascotas->lastItem(),
            ],
            'mascotas' => $mascotas
        ];
    }

    public function obtenerMascota(Request $request)    {
        //if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

       
        $personas = Personas::select('id', 'nombre', 'apellidos')->get(); //take para que solo obtenga un registro
        return ['personas' => $personas];
    }

    public function obtenerMascotaID(Request $request){
        //metodo para obtener el periodo lectivo de la malla registrada
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $obtenerID = Mascotas::join('personas', 'mascotas.idPersona', 'personas.id')
                        ->select('mascotas.id', 'mascotas.idPersona', 'mascotas.nombreMacota', 'personas.nombre', 'personas.apellidos')
                                ->where('mascotas.idPersona','=',$id)->get(); //take para que solo obtenga un registro
        return ['obtenerID' => $obtenerID];
        
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
        
            
            $mascota = new Mascota();
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
