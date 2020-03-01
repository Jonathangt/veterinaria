<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personas;
use App\Clientes;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Http\Requests\StoreClientes;
use App\Http\Requests\UpdateClientes;



class ClientesController extends Controller
{
    public function index(Request $request)    {
       
        if (!$request->ajax()) return redirect('/');//idPersona para valiar los accesos mediante peticion ajax
       
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            
            $personas = Clientes::join('personas', 'clientes.idPersona', 'personas.id')
                                    ->join('users', 'personas.id', 'users.idPersona')
                            ->select('clientes.id', 'clientes.idPersona', 'personas.nombre', 'personas.apellidos',
                                    'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 
                                    'users.email')
                            ->orderBy('clientes.id', 'desc')->paginate(10);
                           
        }
        else{
            $personas = Clientes::join('personas', 'clientes.idPersona', 'personas.id')
                            ->join('users', 'personas.id', 'users.idPersona')
                            ->select('clientes.id', 'clientes.idPersona', 'personas.nombre', 'personas.apellidos',
                                    'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 
                                    'users.email')
                            ->where($criterio, 'like', '%'. $buscar . '%')
                            ->orderBy('personas.apellidos', 'desc')->paginate(10);
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
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;

        $personas = Clientes::join('personas', 'clientes.idPersona', 'personas.id')
                                ->join('users', 'personas.id', 'users.idPersona')
                                ->select('clientes.id', 'clientes.idPersona', 
                                        'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                         'personas.direccion', 'personas.telefono', 'personas.celular', 
                                        'users.email')
                                ->where('clientes.id','=',$id)->take(1)->get();
                                                    
        return [ 'personas' => $personas];     

    }

  
    public function store(StoreClientes $request)    {
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
            $persona->estado = '1';
            //$persona->email = $request->email;
            $persona->save();

            $cliente = new Clientes();
            $cliente->idPersona = $persona->id; //le paso el id persona a la tabla clientes
            $cliente->save();


            $usuario = new User();
            $usuario->name = $request->nombre;
            $usuario->idPersona = $persona->id;
            $usuario->email = $request->email;
            $usuario->password = bcrypt( $request->cedula);
            $usuario->rol = '2';
            $usuario->estado = '1';
            $usuario->idPersona = $persona->id;
            $usuario->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }
    

    public function update(UpdateClientes $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            $clientes = Clientes::findOrFail($request->id);

            $persona = Personas::findOrFail($clientes->idPersona);

            $persona->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $persona->id = $persona->id;
            $persona->nombre = $request->nombre;
            $persona->apellidos = $request->apellidos;
            $persona->cedula = $request->cedula;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->celular = $request->celular;
            
            $persona->save();

            $clientes->idPersona = $persona->id;; //le paso el id persona a la tabla clientes
            $clientes->save();

            $usuario = User::where("idPersona", $persona->id)->first();
        
            $usuario->name = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = bcrypt( $request->cedula);
            $usuario->idPersona = $persona->id;
            $usuario->save();
       
           
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function destroy($id)  {

        $clientes = Clientes::findOrFail($id);
        $personas = Personas::findOrFail($clientes->idPersona);
        $user = User::findOrFail($personas->id);

        
        $personas = Personas::findOrFail($clientes->idPersona)->delete();
        $clientes = Clientes::findOrFail($id)->delete();
        $user = User::findOrFail($personas->id)->delete();
       
        /* $persona = Personas::findOrFail($clientes->idPersona)->delete();

        $user = User::select('users.id', 'users.idPersona')
        ->where('users.idPersona', '=', $persona)->delete();

        $clientes = Clientes::findOrFail($id)->delete();*/
    } 

    public function selectCliente(Request $request){
        //Metodo para filtrar las personas en el registro de mascotas
        if (!$request->ajax()) return redirect('/');
        //$id = $request->id;
        $personas = Clientes::join('personas', 'clientes.idPersona', 'personas.id')
                            ->select('clientes.id', 'clientes.idPersona', 'personas.nombre', 'personas.apellidos')
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


}
