<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personas;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class ClientesController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = Personas::/*join('users', 'personas.idUsuario', 'users.id')*/
                            select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                    'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email')
                            ->orderBy('personas.id', 'desc')->paginate(10);
        }
        else{
            $personas =  Personas::join('users', 'personas.idUsuario', 'users.id')
                        ->select('users.email', 'personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email')
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

    public function obtener(Request $request){ //metodo para obtener el registro y editarlo
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $personas = Personas::join('users', 'personas.idUsuario', 'users.id')
                                ->select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                        'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 
                                        'personas.email', 'users.condicion')
                                ->where('personas.id','=',$id)->get(); 
        return ['personas' => $personas];
    }

    public function selectPersona(Request $request){
        //Metodo para filtarl los s en el modulo de informes
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $personas = Personas::select('personas.id', 'personas.nombre', 'personas.apellidos')
                                
                                ->orderBy('personas.apellidos', 'asc')->get();

        return ['personas' => $personas];
    }

    public function selectPersonaID(Request $request){
        //Metodo para filtarl los s en el modulo de informes
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
       
        $personas = Personas::select('personas.id', 'personas.nombre', 'personas.apellidos')
                                ->where('personas.id','=',$id)
                                ->orderBy('personas.apellidos', 'asc')->take(1)->get(); 
        return ['personas' => $personas];
    }


    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            $persona = new Personas();
            $persona->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $persona->id = $request->id;
            $persona->nombre = $request->nombre;
            $persona->apellidos = $request->apellidos;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->save();

            $usuario = new User();
            $usuario->name = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = bcrypt( $request->cedula);
            $usuario->rol = '2';
            $usuario->estado = '1';
            $usuario->condicion = $persona->id;
            $usuario->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function update(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();
            
            $persona = Personas::findOrFail($request->id);

            $usuario = User::where("condicion", $persona->id)->first();

            $persona->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $persona->id = $request->id;
            $persona->nombre = $request->nombre;
            $persona->apellidos = $request->apellidos;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->celular = $request->celular;       
            $persona->email = $request->email;    
            $persona->save();

           // $usuario = User::findOrFail($request->email);
            $usuario->name = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->cedula);
            $usuario->rol = '2'; //rol cliente
            $usuario->estado = '1';
            $usuario->condicion = $persona->id;
            $usuario->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function destroy($id)  {
        $personas = Personas::findOrFail($id)->delete();

        $user = User::select('users.id', 'users.condicion')
                        ->where('users.condicion', '=', $id)
                        ->delete(); //elimino al usuario del 
    } 


}
