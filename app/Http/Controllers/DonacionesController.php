<?php

namespace App\Http\Controllers;
use App\User;
use App\Donaciones;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DonacionesController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                    ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                            'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion',  'donaciones.fechaInicio', 
                                            'donaciones.fechaFin', 'donaciones.email', 'users.name')
                                    ->orderBy('donaciones.id', 'desc')->paginate(10);
        }
        else{
            $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                    ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                            'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion',  'donaciones.fechaInicio', 
                                            'donaciones.fechaFin', 'donaciones.email', 'users.name')
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

         

            //se guarda con el fotmato ok
            /*$donacion->fechaInicio = Carbon::parse($request->fechaInicio); 2020-02-15 01:05:00*/

         //   $now = Carbon::now();
           // $now = $request->direccion;
            //Feb 11, 2020  $donacion->fechaInicio = $now->toFormattedDateString();
          
           /* $donacion->fechaInicio = $now->toFormattedDateString();
            $donacion->fechaFin =   $now->format('H:i');
           */

          //Carbon::toFormattedDateString($request->fechaInicio);

            $donacion = new Donaciones();

            $donacion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $donacion->recaudacion = $request->recaudacion;
            $donacion->lugar = $request->lugar;
            $donacion->motivo = $request->motivo;
            $donacion->telefono = $request->telefono;
            $donacion->direccion = $request->direccion;
            $donacion->fechaInicio = Carbon::parse($request->fechaInicio)->format('d-m-Y');
            $donacion->fechaFin = Carbon::parse($request->fechaFin)->format('d-m-Y');
            $donacion->email = $request->email;
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
            $donacion->fechaInicio = Carbon::parse($request->fechaInicio)->format('d-m-Y');
            $donacion->fechaFin = Carbon::parse($request->fechaFin)->format('d-m-Y');
            $donacion->email = $request->email;           
            $donacion->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
       // if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
                                ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                                'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 'users.name', 'donaciones.email', 
                                'donaciones.fechaInicio', 'donaciones.fechaFin')
                                ->where('donaciones.id','=',$id)->get();
        return ['donacion' => $donacion];
    }

    /*
    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $donacion = Donaciones::findOrFail($request->id);
        $donacion->estado = '0';
        $donacion->save();
    }*/

    /*
    public function activar(Request $request)  {
        if (!$request->ajax()) return redirect('/');
        $donacion = Donaciones::findOrFail($request->id);
        $donacion->estado = '1';
        $donacion->save();
    }*/

    public function mostrarDonacion(Request $request)    {
        // if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
         
      
        /*
        $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
        ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 
                'donaciones.email', 'donaciones.fechaInicio', 'donaciones.fechaFin', 'users.name')
        ->orderBy('donaciones.id', 'desc')->take(1)->get();
        return[ 'donacion'=>$donacion];
      

       $donacion= Donaciones::all()->last();
        return[ $donacion];*/
        
       
        $donacion = Donaciones::join('users', 'donaciones.idUsuario', 'users.id')
        ->select('donaciones.id', 'donaciones.idUsuario', 'donaciones.recaudacion', 'donaciones.lugar',
                'donaciones.motivo', 'donaciones.telefono', 'donaciones.direccion', 
                'donaciones.email', 'donaciones.fechaInicio', 'donaciones.fechaFin', 'users.name')
                ->orderBy('donaciones.id', 'desc')
                ->paginate(1);
        

        return ['donacion' => $donacion ];

        
     }

     public function destroy($id)  {
        $donacion = Donaciones::findOrFail($id)->delete();
    } 


   /* public function obtenerEstado(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
        $donacion=DB::table('donaciones as p')
        ->select( DB::raw('SUM(p.estado) as total'))->get();
        return[ 'donacion'=>$donacion];
    }*/

}
