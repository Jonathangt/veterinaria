<?php

namespace App\Http\Controllers;
use App\User;
use App\Donaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DonacionesController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                    ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                            'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'donaciones.estado', 'users.name', 'users.email')
                                    ->orderBy('donaciones.id', 'desc')->paginate(10);
        }
        else{
            $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                    ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                            'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'donaciones.estado', 'users.name', 'users.email')
                                    ->where($criterio, 'like', '%'. $buscar . '%')
                                    ->orderBy('donaciones.id', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $donacion->total(),
                'current_page' => $donacion->currentPage(),
                'per_page'     => $donacion->perPage(),
                'last_page'    => $donacion->lastPage(),
                'from'         => $donacion->firstItem(),
                'to'           => $donacion->lastItem(),
            ],
            'donacion' => $donacion
        ];
    }

    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $donacion = new Donaciones();
            $donacion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $donacion->recaudacion = $request->recaudacion;
            $donacion->lugar = $request->lugar;
            $donacion->motivo = $request->motivo;
            $donacion->telefono = $request->telefono;
            $donacion->direccion = $request->direccion;
            $donacion->estado = '1'; //activo
            $donacion->save();

    
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            
            $donacion = Donaciones::findOrFail($request->id);
            $donacion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $donacion->recaudacion = $request->recaudacion;
            $donacion->lugar = $request->lugar;
            $donacion->motivo = $request->motivo;
            $donacion->telefono = $request->telefono;
            $donacion->direccion = $request->direccion;
            $donacion->estado = '1'; //activo
            $donacion->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'donaciones.estado', 'users.name', 'users.email')
                                ->where('donaciones.id','=',$id)->get();
        return ['donacion' => $donacion];
    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $donacion = Donaciones::findOrFail($request->id);
        $donacion->estado = '0';
        $donacion->save();
    }

    public function activar(Request $request)  {
        if (!$request->ajax()) return redirect('/');
        $donacion = Donaciones::findOrFail($request->id);
        $donacion->estado = '1';
        $donacion->save();
    }

    public function mostrarDonacion(Request $request)    {
        // if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
         
        /*$donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
        ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'donaciones.estado', 'users.name', 'users.email')
        ->orderBy('donaciones.id', 'desc')->take(1)->get();
        return[ 'donacion'=>$donacion];*/

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                    ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                            'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'donaciones.estado', 'users.name', 'users.email')
                                    ->orderBy('donaciones.id', 'desc')->paginate(10);
        }
       
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $donacion->total(),
                'current_page' => $donacion->currentPage(),
                'per_page'     => $donacion->perPage(),
                'last_page'    => $donacion->lastPage(),
                'from'         => $donacion->firstItem(),
                'to'           => $donacion->lastItem(),
            ],
            'donacion' => $donacion
        ];

        
     }


   

    public function obtenerEstado(Request $request)    {
       // if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
        
        $donacion=DB::table('donaciones as p')
        ->select( DB::raw('SUM(p.estado) as total'))->get();
        return[ 'donacion'=>$donacion];
        
    }

}
