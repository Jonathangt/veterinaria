<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personas;
use App\Clientes;
use App\User;
use App\Http\Requests\StoreDatos;
use App\Http\Requests\UpdateDatos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class DatosController extends Controller
{
    public function index(Request $request)    {
       // if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        $userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
        
        if ($buscar==''){
            $personas = Personas::/*join('users', 'personas.idUsuario', 'users.id')*/
                            select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                    'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email',
                                    'personas.estado')
                            ->where('personas.estado', '=', '0')
                            ->orderBy('personas.id', 'desc')->paginate(10);
        }
        else{
            $personas =  Personas::/*join('users', 'personas.idUsuario', 'users.id')*/
                            select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email',
                                'personas.estado')
                            //->where('personas.idUsuario', '=', $userID)
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
            $persona->estado = '0';
            //$persona->email = \Auth::user()->email; //obtengo el enail del user 
            $persona->save();

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

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }



    public function obtener(Request $request){ //metodo para obtener el registro y editarlo
        //if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $personas = Personas::join('users', 'personas.idUsuario', 'users.id')
                                ->select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                        'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email')
                                ->where('personas.id','=',$id)->get(); 
        return ['personas' => $personas];
    }

    public function selectDatos(Request $request){
        //Metodo para filtar el nombre de la persona en el registro de la mascota para adocion
        //if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        //$userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
        $personas = Personas::select('personas.id', 'personas.nombre', 'personas.apellidos')
                                //->where('personas.idUsuario', '=', $userID)
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


    

   

    public function destroy($id)  {
        $personas = Personas::findOrFail($id)->delete();

       /* $user = User::select('users.id', 'users.condicion')
                        ->where('users.condicion', '=', $id)
                        ->delete(); //elimino al usuario del */
    } 


    /**Metodos para el usuario, y cliente */

    public function indexUsuario(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
 
         $buscar = $request->buscar;
         $criterio = $request->criterio;
 
         $userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
         
         if ($buscar==''){
             $personas = Personas::join('users', 'personas.idUsuario', 'users.id')
                             ->select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                     'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email',
                                     'personas.estado')
                             ->where('personas.idUsuario', '=', $userID)
                             ->orderBy('personas.id', 'desc')->paginate(10);
         }
         else{
             $personas =  Personas::join('users', 'personas.idUsuario', 'users.id')
                            ->select('personas.id', 'personas.idUsuario', 'personas.nombre', 'personas.apellidos',
                                 'personas.cedula', 'personas.direccion', 'personas.telefono', 'personas.celular', 'personas.email',
                                 'personas.estado')
                            ->where('personas.idUsuario', '=', $userID)
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

    public function storeUsuario(Request $request)    {
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
            $persona->estado = '0'; /*para que el adm no pueda editar ni eliminar
                                 los datos //cambiar a 1 para q el admin no pueda editar ni eliminar*/
            //$persona->email = \Auth::user()->email; //obtengo el enail del user 
            $persona->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function selectDatosUsuario(Request $request){
        //Metodo para filtar el nombre de la persona en el registro de la mascota para adocion
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
        $personas = Personas::select('personas.id', 'personas.nombre', 'personas.apellidos')
                                ->where('personas.idUsuario', '=', $userID)
                                ->orderBy('personas.apellidos', 'asc')->get();

        return ['personas' => $personas];
    }

    public function selectDatosCliente(Request $request){
        //Metodo para filtar el nombre de la persona en el registro de la mascota para adocion
        //if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $idPersona = \Auth::user()->idPersona;  ///obtengo el campo id del usuario autenticado
        $personas = Personas::select('personas.id', 'personas.nombre', 'personas.apellidos')
                                ->where('personas.id', '=', $idPersona)
                                ->orderBy('personas.apellidos', 'asc')->get();

        return ['personas' => $personas];
    }




}
