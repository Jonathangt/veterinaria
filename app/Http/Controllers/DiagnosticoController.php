<?php

namespace App\Http\Controllers;
use App\User;
use App\Diagnostico;
use App\Mascotas;
use App\Personas;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;


class DiagnosticoController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        //tengo que obtener la condicion y el id de la persona
        $userID = \Auth::user()->condicion;  ///obtengo diagnostico: 1 //ok

       // $persona = Personas::findOrFail($diagnosticoa); //otengo toda la coleccion persona //return->id //ok


      // return ['userID' => $userID];
        
        if ($buscar==''){
            $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                        ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                        ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                        ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idPersona',
                                                'diagnostico.fechaAtencion', 'diagnostico.horaAtencion', 
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota',  'personas.email', 
                                                'users.name', 'users.password')
                                        ->where('diagnostico.idPersona', '=', $userID)
                                        ->orderBy('diagnostico.id', 'desc')->paginate(10);
        }
        else{
            $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                        ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                        ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                        ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idPersona',
                                                'diagnostico.fechaAtencion', 'diagnostico.horario', 
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula', 'users.condicion',
                                                'mascotas.nombreMascota')
                                        ->where($criterio, 'like', '%'. $buscar . '%')
                                        ->orderBy('diagnostico.id', 'desc')->paginate(10);
        }
        
       
        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $diagnostico->total(),
                'current_page' => $diagnostico->currentPage(),
                'per_page'     => $diagnostico->perPage(),
                'last_page'    => $diagnostico->lastPage(),
                'from'         => $diagnostico->firstItem(),
                'to'           => $diagnostico->lastItem(),
            ],
            'diagnostico' => $diagnostico
        ];
    }

    public function store(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();        

            //se guarda con el fotmato ok
            /*$diagnostico->fechaInicio = Carbon::parse($request->fechaInicio); 2020-02-15 01:05:00*/

            
           // $now = $request->direccion;
            //Feb 11, 2020  $diagnostico->fechaInicio = $now->toFormattedDateString();
          
           /* $diagnostico->fechaInicio = $now->toFormattedDateString();
            $diagnostico->fechaFin =   $now->format('H:i');
           */

          //Carbon::toFormattedDateString($request->fechaInicio);
            $now = Carbon::now();
            $diagnostico = new Diagnostico();

            $diagnostico->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $diagnostico->idPersona = $request->idPersona;
            $diagnostico->idMascota = $request->idMascota;

            $diagnostico->esterilizado = $request->esterilizado;
            $diagnostico->tipoProcedimiento = $request->tipoProcedimiento;
            $diagnostico->modoOptencion = $request->modoOptencion;
            $diagnostico->observacionDiagnostico = $request->observacionDiagnostico;
            $diagnostico->fechaAtencion = $now->toFormattedDateString(); //obtengo la fecha del registro
            $diagnostico->horaAtencion =  $now->format('H:i'); //otengo la hora del registro
            $diagnostico->medicamento = $request->medicamento;
            $diagnostico->horario = $request->horario;
            $diagnostico->observacionReceta = $request->observacionReceta;
            $diagnostico->save();
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            
            $now = Carbon::now();
            $diagnostico = Diagnostico::findOrFail($request->id);
            $diagnostico->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $diagnostico->idPersona = $request->idPersona;
            $diagnostico->idMascota = $request->idMascota;
            $diagnostico->esterilizado = $request->esterilizado;
            $diagnostico->tipoProcedimiento = $request->tipoProcedimiento;
            $diagnostico->modoOptencion = $request->modoOptencion;
            $diagnostico->observacionDiagnostico = $request->observacionDiagnostico;
            $diagnostico->fechaAtencion = $now->toFormattedDateString(); //obtengo la fecha del registro
            $diagnostico->horaAtencion =  $now->format('H:i'); //otengo la hora del registro
            $diagnostico->medicamento = $request->medicamento;
            $diagnostico->horario = $request->horario;
            $diagnostico->observacionReceta = $request->observacionReceta;
            $diagnostico->save();
        
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function obtenerDatos(Request $request){//metodo para editar y visualizar los datos
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                    ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                    ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                    ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idMascota',
                                             'diagnostico.idPersona', 'diagnostico.esterilizado',
                                            'diagnostico.tipoProcedimiento', 'diagnostico.modoOptencion', 
                                            'diagnostico.observacionDiagnostico', 'diagnostico.fechaAtencion', 
                                            'diagnostico.horaAtencion', 'diagnostico.medicamento',
                                            'diagnostico.horario', 'diagnostico.observacionReceta',
                                            'users.name', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                            'mascotas.nombreMascota')
                                    ->where('diagnostico.id','=',$id)->get();
        return ['diagnostico' => $diagnostico];
    }

    public function selectMascota(Request $request){//obtengo las mascotas segun el idPersona (Cliente) vista Registrar Consulta
        if (!$request->ajax()) return redirect('/');

       $id = $request->id;
      
       $mascotas = Mascotas::select('mascotas.id', 'mascotas.idPersona', 'mascotas.nombreMascota')
                                   ->where('mascotas.idPersona','=',$id)->get();
        return ['mascotas' => $mascotas];
    }


    public function obtenerConsulta(Request $request){//metodo para que el cliente pueda visualizar la consulta 
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
           
        $id = $request->id;
        $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                    ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                    ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                    ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idMascota',
                                             'diagnostico.idPersona', 'diagnostico.esterilizado',
                                            'diagnostico.tipoProcedimiento', 'diagnostico.modoOptencion', 
                                            'diagnostico.observacionDiagnostico', 'diagnostico.fechaAtencion', 
                                            'diagnostico.horaAtencion', 'diagnostico.medicamento',
                                            'diagnostico.horario', 'diagnostico.observacionReceta',
                                            'users.name', 'personas.nombre', 'personas.apellidos', 'personas.cedula', 'personas.email',
                                            'mascotas.nombreMascota')
                                    ->where('diagnostico.id','=',$id)->get();

        return ['diagnostico' => $diagnostico];
                                            
    }

    public function indexConsulta(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;

       
        $userID = \Auth::user()->condicion;  ///obtengo el campo diagnostico del usuario autenticado

       // $persona = Personas::findOrFail($diagnosticoa); //otengo toda la coleccion persona //return->id //ok
        
        if ($buscar==''){
            $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                        ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                        ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                        ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idPersona',
                                                'diagnostico.fechaAtencion', 'diagnostico.horaAtencion', 
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        ->where('diagnostico.idPersona', '=', $userID)
                                        ->orderBy('diagnostico.id', 'desc')->paginate(10);
        }
        else{
            $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                        ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                        ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                        ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idPersona',
                                                'diagnostico.fechaAtencion', 'diagnostico.horaAtencion', 
                                                'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                                'mascotas.nombreMascota')
                                        ->where('diagnostico.idPersona', '=', $userID)
                                        ->where($criterio, 'like', '%'. $buscar . '%')
                                        ->orderBy('diagnostico.id', 'desc')->paginate(10);
        }
        
       
        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $diagnostico->total(),
                'current_page' => $diagnostico->currentPage(),
                'per_page'     => $diagnostico->perPage(),
                'last_page'    => $diagnostico->lastPage(),
                'from'         => $diagnostico->firstItem(),
                'to'           => $diagnostico->lastItem(),
            ],
            'diagnostico' => $diagnostico
        ];
    }


    public function destroy($id)  {
        $diagnostico = Diagnostico::findOrFail($id)->delete();
    }
    
    public function pdfReceta(Request $request, $id){
        
        //obtengo el periodo de la malla curricular
        $diagnostico = Diagnostico::join('users', 'diagnostico.idUsuario', 'users.id')
                                    ->join('personas', 'diagnostico.idPersona', 'personas.id')
                                    ->join('mascotas', 'diagnostico.idMascota', 'mascotas.id')
                                    ->select('diagnostico.id', 'diagnostico.idUsuario', 'diagnostico.idMascota',
                                            'diagnostico.idPersona', 'diagnostico.esterilizado',
                                            'diagnostico.tipoProcedimiento', 'diagnostico.modoOptencion', 
                                            'diagnostico.observacionDiagnostico', 'diagnostico.fechaAtencion', 
                                            'diagnostico.horaAtencion', 'diagnostico.medicamento',
                                            'diagnostico.horario', 'diagnostico.observacionReceta',
                                            'users.name', 'personas.nombre', 'personas.apellidos', 'personas.cedula',
                                            'mascotas.nombreMascota', 'mascotas.especie', 'mascotas.sexo', 'mascotas.raza')
                                    ->where('diagnostico.id','=',$id)->get();

        $pdf = \PDF::loadView('pdf.diagnostico_pdf',['diagnostico'=>$diagnostico]);
        //->setPaper('a4', 'landscape');//formato horizontal

        //return $pdf->download('Receta de '.$diagnostico[0]->nombreMascota.'.pdf');          
        return $pdf->stream('Consulta de '.$diagnostico[0]->nombreMascota.'.pdf');          
    }


}
