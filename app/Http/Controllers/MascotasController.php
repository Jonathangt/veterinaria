<?php

namespace App\Http\Controllers;
use App\Mascotas;
use App\Personas;
use App\Clientes;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MascotasController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $mascotas = Mascotas::join('clientes', 'mascotas.idCliente', 'clientes.id')
                                ->join('personas', 'clientes.idPersona', 'personas.id')
                                ->join('users', 'mascotas.idUsuario', 'users.id')
                                ->select('mascotas.id', 'mascotas.nombreMascota', 'mascotas.especie',
                                            'mascotas.raza', 'mascotas.sexo', 'personas.nombre', 'personas.apellidos')
                                ->orderBy('mascotas.id', 'desc')->paginate(10);
        }
        else{
            $mascotas =  Mascotas::join('clientes', 'mascotas.idCliente', 'clientes.id')
                                ->join('personas', 'clientes.idPersona', 'personas.id')
                                ->join('users', 'mascotas.idUsuario', 'users.id')
                                ->select('mascotas.id', 'mascotas.nombreMascota', 'mascotas.especie',
                                            'mascotas.raza', 'mascotas.sexo', 'personas.nombre', 'personas.apellidos')
                                ->where($criterio, 'like', '%'. $buscar . '%')
                                ->orderBy('personas.apellidos', 'desc')->paginate(10);
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


    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            $mascotas = new Mascotas();
            $mascotas->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $mascotas->idCliente = $request->idCliente;
            $mascotas->nombreMascota = $request->nombreMascota;
            $mascotas->especie = $request->especie;
            $mascotas->raza = $request->raza;
            $mascotas->fechaNacimiento = Carbon::parse($request->fechaNacimiento)->format('d-m-Y');
            $mascotas->edad = $request->edad;
            $mascotas->sexo = $request->sexo;
            $mascotas->save();
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            $mascotas = Mascotas::findOrFail($request->id);
            
            $mascotas->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $mascotas->idCliente = $request->idCliente;
            $mascotas->nombreMascota = $request->nombreMascota;
            $mascotas->especie = $request->especie;
            $mascotas->raza = $request->raza;
            $mascotas->fechaNacimiento = Carbon::parse($request->fechaNacimiento)->format('d-m-Y');
            $mascotas->edad = $request->edad;
            $mascotas->sexo = $request->sexo;
            $mascotas->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function destroy($id)  {
        $mascotas = Mascotas::findOrFail($id)->delete();
    } 

    public function obtener(Request $request){ //metodo para obtener el registro y editarlo
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $mascotas = Mascotas::join('clientes', 'mascotas.idCliente', 'clientes.id')
                          ->join('personas', 'clientes.idPersona', 'personas.id')
                          ->join('users', 'personas.id', 'users.idPersona')
                       -> select('mascotas.id', 'mascotas.idCliente', 'mascotas.nombreMascota', 'mascotas.especie',
                                    'mascotas.raza', 'mascotas.fechaNacimiento', 'mascotas.edad', 'mascotas.sexo',
                                    'personas.nombre', 'personas.apellidos', 'personas.cedula', 'personas.direccion', 'personas.telefono',
                                    'personas.celular', 'users.email')
                        ->where('mascotas.id','=',$id)->get(); 
        return ['mascotas' => $mascotas];
    }

   


    




























    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
        //if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $mascotas = Mascotas::join('personas', 'mascotas.idCliente', 'personas.id')
                    ->join('users', 'mascotas.idUsuario', 'users.id')
                    ->select('mascotas.id', 'mascotas.idCliente', 'mascotas.nombreMascota', 'mascotas.especie',
                                'mascotas.raza', 'mascotas.fechaNacimiento', 'mascotas.edad', 'mascotas.sexo',
                                'users.name', 'users.email', 'users.rol', 'users.estado', 'users.password',  
                                'personas.nombre', 'personas.apellidos', 'personas.cedula', 'personas.direccion', 'personas.telefono',
                                'personas.celular')
                                ->where('mascotas.id','=',$id)->get();
        return ['mascotas' => $mascotas];

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
        $obtenerID = Mascotas::join('personas', 'mascotas.idCliente', 'personas.id')
                        ->select('mascotas.id', 'mascotas.idCliente', 'mascotas.nombreMacota', 'personas.nombre', 'personas.apellidos')
                                ->where('mascotas.idCliente','=',$id)->get(); //take para que solo obtenga un registro
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

  



}
