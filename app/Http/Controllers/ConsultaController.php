<?php

namespace App\Http\Controllers;
use App\User;
use App\Consultas;
use App\Mascotas;
use App\Personas;
use App\Clientes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

use App\Http\Requests\StoreConsultas;
use App\Http\Requests\UpdateConsultas;


class ConsultaController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        //tengo que obtener la condicion y el id de la persona
        $userID = \Auth::user()->condicion;  ///obtengo diagnostico: 1 //ok
        
        if ($buscar==''){
            $consulta = Consultas:://join('users', 'consultas.idUsuario', 'users.id')
                                        join('clientes', 'consultas.idCliente', 'clientes.id')
                                        ->join('personas', 'clientes.idPersona', 'personas.id')
                                        ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                        ->select('consultas.id', 'consultas.fechaAtencion', 'consultas.horaAtencion', 
                                                'consultas.fechaSgtConsulta', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        //->where('consultas.idCliente', '=', $userID)
                                        ->orderBy('consultas.id', 'desc')->paginate(10);
        }
        else{
            $consulta = Consultas::join('clientes', 'consultas.idCliente', 'clientes.id')
                                        ->join('personas', 'clientes.idPersona', 'personas.id')
                                        ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                        ->select('consultas.id', 'consultas.fechaAtencion', 'consultas.horaAtencion', 
                                                'consultas.fechaSgtConsulta', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        ->where($criterio, 'like', '%'. $buscar . '%')
                                        ->orderBy('consultas.id', 'desc')->paginate(10);
        }
        
       
        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $consulta->total(),
                'current_page' => $consulta->currentPage(),
                'per_page'     => $consulta->perPage(),
                'last_page'    => $consulta->lastPage(),
                'from'         => $consulta->firstItem(),
                'to'           => $consulta->lastItem(),
            ],
            'consulta' => $consulta
        ];
    }

    public function store(StoreConsultas $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();        

            //se guarda con el fotmato ok
            /*$consulta->fechaInicio = Carbon::parse($request->fechaInicio); 2020-02-15 01:05:00*/

            
           // $now = $request->direccion;
            //Feb 11, 2020  $consulta->fechaInicio = $now->toFormattedDateString();
          
           /* $consulta->fechaInicio = $now->toFormattedDateString();
            $consulta->fechaFin =   $now->format('H:i');
           */

          //Carbon::toFormattedDateString($request->fechaInicio);
            $now = Carbon::now();
            $consulta = new Consultas();

            $consulta->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $consulta->idCliente = $request->idCliente;
            $consulta->idMascota = $request->idMascota;

            $consulta->esterilizado = $request->esterilizado;
            $consulta->tipoProcedimiento = $request->tipoProcedimiento;
            $consulta->modoOptencion = $request->modoOptencion;
            $consulta->peso = $request->peso;
            $consulta->observacionDiagnostico = $request->observacionDiagnostico;
            $consulta->fechaAtencion = $now->toFormattedDateString(); //obtengo la fecha del registro
            $consulta->horaAtencion =  $now->format('H:i'); //otengo la hora del registro
            $consulta->medicamento = $request->medicamento;
            $consulta->horario = $request->horario;
            $consulta->observacionReceta = $request->observacionReceta;
            $consulta->fechaSgtConsulta =  Carbon::parse($request->fechaSgtConsulta)->toFormattedDateString();
            $consulta->save();
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(UpdateConsultas $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            
            $consulta = Consultas::findOrFail($request->id);
            $consulta->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $consulta->idCliente = $request->idCliente;
            $consulta->idMascota = $request->idMascota;
            $consulta->esterilizado = $request->esterilizado;
            $consulta->tipoProcedimiento = $request->tipoProcedimiento;
            $consulta->modoOptencion = $request->modoOptencion;
            $consulta->peso = $request->peso;
            $consulta->observacionDiagnostico = $request->observacionDiagnostico;
            //$consulta->fechaAtencion = $now->toFormattedDateString(); //obtengo la fecha del registro
            //$consulta->horaAtencion =  $now->format('H:i'); //otengo la hora del registro
            $consulta->medicamento = $request->medicamento;
            $consulta->horario = $request->horario;
            $consulta->observacionReceta = $request->observacionReceta;
            $consulta->fechaSgtConsulta =  Carbon::parse($request->fechaSgtConsulta)->toFormattedDateString();
            $consulta->save();
        
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $consulta = Consultas::join('users', 'consultas.idUsuario', 'users.id')
                                    ->join('clientes', 'consultas.idCliente', 'clientes.id')
                                    ->join('personas', 'clientes.idPersona', 'personas.id')
                                    ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                    ->select('consultas.id', 'consultas.idUsuario', 'consultas.idMascota',
                                             'consultas.idCliente', 'consultas.esterilizado',
                                            'consultas.tipoProcedimiento', 'consultas.modoOptencion', 'consultas.peso', 
                                            'consultas.observacionDiagnostico', 'consultas.fechaAtencion', 
                                            'consultas.horaAtencion', 'consultas.medicamento',
                                            'consultas.horario', 'consultas.observacionReceta', 'consultas.fechaSgtConsulta',
                                            'users.name', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                            'mascotas.nombreMascota')
                                    ->where('consultas.id','=',$id)->get();
        return ['consulta' => $consulta];
    }


    public function destroy($id)  {
        $diagnostico = Consultas::findOrFail($id)->delete();
    }

      
    public function pdfReceta(Request $request, $id){
        
        $consulta = Consultas::join('users', 'consultas.idUsuario', 'users.id')
                                    ->join('clientes', 'consultas.idCliente', 'clientes.id')
                                    ->join('personas', 'clientes.idPersona', 'personas.id')
                                    ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                    ->select('consultas.id', 'consultas.idUsuario', 'consultas.idMascota',
                                            'consultas.idCliente', 'consultas.esterilizado',
                                            'consultas.tipoProcedimiento', 'consultas.modoOptencion', 
                                            'consultas.observacionDiagnostico', 'consultas.fechaAtencion', 
                                            'consultas.horaAtencion', 'consultas.medicamento', 'consultas.peso',
                                            'consultas.horario', 'consultas.observacionReceta', 'consultas.fechaSgtConsulta',
                                            'users.name', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                            'mascotas.nombreMascota', 'mascotas.especie', 'mascotas.sexo', 'mascotas.raza')
                                    ->where('consultas.id','=',$id)->get();

        $pdf = \PDF::loadView('pdf.consulta_pdf',['consulta'=>$consulta]);
        //->setPaper('a4', 'landscape');//formato horizontal

        //return $pdf->download('Receta de '.$diagnostico[0]->nombreMascota.'.pdf');          
        return $pdf->stream('Consulta de '.$consulta[0]->nombreMascota.'.pdf');          
    }


  
    public function selectMascota(Request $request){//obtengo las mascotas segun el idPersona (Cliente) vista Registrar Consulta
        if (!$request->ajax()) return redirect('/');

       $id = $request->id;
      
       $mascotas = Mascotas::select('mascotas.id', 'mascotas.idCliente', 'mascotas.nombreMascota')
                                   ->where('mascotas.idCliente','=',$id)->get();
        return ['mascotas' => $mascotas];
    }

    

    /**Metodos para el cliente */

    public function indexCliente(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;

       
        $personaID = \Auth::user()->idPersona;  ///obtengo el campo diagnostico del usuario autenticado
        
        if ($buscar==''){
            $consulta = Consultas::join('users', 'consultas.idUsuario', 'users.id')
                                        ->join('clientes', 'consultas.idCliente', 'clientes.id')
                                        ->join('personas', 'clientes.idPersona', 'personas.id')
                                        ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                        ->select('consultas.id', 'consultas.idUsuario', 'consultas.idCliente',
                                                'consultas.fechaAtencion', 'consultas.horaAtencion', 'consultas.fechaSgtConsulta',
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        ->where('personas.id', '=', $personaID)
                                        ->orderBy('consultas.id', 'desc')->paginate(10);
        }
        else{
            $consulta = Consultas::join('users', 'consultas.idUsuario', 'users.id')
                                        ->join('clientes', 'consultas.idCliente', 'clientes.id')
                                        ->join('personas', 'clientes.idPersona', 'personas.id')
                                        ->join('mascotas', 'consultas.idMascota', 'mascotas.id')
                                        ->select('consultas.id', 'consultas.idUsuario', 'consultas.idCliente',
                                                'consultas.fechaAtencion', 'consultas.horaAtencion', 'consultas.fechaSgtConsulta',
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        ->where($criterio, 'like', '%'. $buscar . '%')
                                        ->where('personas.id', '=', $personaID)
                                        ->orderBy('consultas.id', 'desc')->paginate(10);
        }
        
       
        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $consulta->total(),
                'current_page' => $consulta->currentPage(),
                'per_page'     => $consulta->perPage(),
                'last_page'    => $consulta->lastPage(),
                'from'         => $consulta->firstItem(),
                'to'           => $consulta->lastItem(),
            ],
            'consulta' => $consulta
        ];
    }

    

}
