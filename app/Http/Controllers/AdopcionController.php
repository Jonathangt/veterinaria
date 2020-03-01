<?php

namespace App\Http\Controllers;
use App\Adopcion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Http\Requests\StoreAdopcion;
use App\Http\Requests\UpdateAdopcion;

use PDF;

class AdopcionController extends Controller
{
    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                   ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        else{
            $adopcion =  Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                    ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->where($criterio, 'like', '%'. $buscar . '%')
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $adopcion->total(),
                'current_page' => $adopcion->currentPage(),
                'per_page'     => $adopcion->perPage(),
                'last_page'    => $adopcion->lastPage(),
                'from'         => $adopcion->firstItem(),
                'to'           => $adopcion->lastItem(),
            ],
            'adopcion' => $adopcion
        ];
    }

    public function obtener(Request $request){//metodo para editar y visualizar los datos

        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;

        $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.especie',
                                        'adopcion.raza', 'adopcion.fechaNacimiento', 'adopcion.edad', 
                                        'adopcion.observacion', 'adopcion.imagen', 
                                        'personas.nombre', 'personas.apellidos', 'personas.cedula',  'personas.direccion',
                                        'personas.telefono',  'personas.celular')
                               // ->orderBy('adopcion.id', 'desc')
                                ->where('adopcion.id','=',$id)->get(); 

        return ['adopcion' => $adopcion];
    }

   
    public function store(StoreAdopcion $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();

            //$now = Carbon::now();

            $exploded = explode(',', $request->imagenMiniatura);
            $decode = base64_decode($exploded[1]);
            $imagenName = Str::random(20) . '.jpg';
            //$path = public_path().'/'.'informacion/'.$imagenName;
            $path = public_path().'/mascotas/'.$imagenName;
            file_put_contents($path, $decode);
        
            $adopcion = new Adopcion();
            //$adopcion->idUsuario = \Auth::user()->id; //obtengo el id del user 
            $adopcion->idPersona = $request->idPersona;
            $adopcion->nombreMascota = $request->nombreMascota;
            $adopcion->especie = $request->especie;
            $adopcion->raza = $request->raza;
            $adopcion->fechaNacimiento = Carbon::parse($request->fechaNacimiento)->toFormattedDateString();
            $adopcion->edad = $request->edad;
            $adopcion->observacion = $request->observacion;
            $adopcion->imagen = $imagenName;
            $adopcion->estado = '1';
            $adopcion->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(UpdateAdopcion $request)    {
        if (!$request->ajax()) return redirect('/');

        try{            
            $adopcion = Adopcion::findOrFail($request->id);

            //$now = Carbon::now();
            $adopcion->nombreMascota = $request->nombreMascota;
            $adopcion->especie = $request->especie;
            $adopcion->raza = $request->raza;
            $adopcion->fechaNacimiento = Carbon::parse($request->fechaNacimiento)->toFormattedDateString();
            $adopcion->edad = $request->edad;
            $adopcion->observacion = $request->observacion;

            //if(strncmp($request->imagenMiniatura, 'https://veterinariadobaltoff.online/public_html/mascotas/', 30) === 0){

            $public = public_path().'/mascotas/';

            if(strncmp($request->imagenMiniatura, $public, 30) === 0){
                $exploded = substr($request->imagenMiniatura, -24);
                $adopcion->imagen = $exploded;

            }else{

                $currentPhoto = $adopcion->imagen;
    
                $photo = public_path('mascotas/').$currentPhoto;
        
                if(file_exists($photo)) {
        
                    @unlink($photo);
                        
                }//eliminamos la foto anterior y guardamos la actual

    
                $exploded = explode(',', $request->imagenMiniatura);
                $decode = base64_decode($exploded[1]);
                $imagenName = Str::random(20) . '.jpg';
                //$path = public_path().'/'.'informacion/'.$imagenName;
                $path = public_path().'/mascotas/'.$imagenName;
                file_put_contents($path, $decode);
                $adopcion->imagen = $imagenName;
                
            }
           
            $adopcion->save();

            DB::commit();            

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $adopcion = Adopcion::findOrFail($request->id);
        $adopcion->estado = '0';
        $adopcion->save();
    }

    public function activar(Request $request)  {
        if (!$request->ajax()) return redirect('/');
        $adopcion = Adopcion::findOrFail($request->id);
        $adopcion->estado = '1';
        $adopcion->save();
    }

    public function pdfAdocion(Request $request, $id){
        
        $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                            /*->join('users', 'personas.id', 'users.id')*/
                            ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.especie',
                                    'adopcion.raza', 'adopcion.fechaNacimiento', 'adopcion.edad', 
                                    'adopcion.observacion', 'adopcion.imagen', 
                                    'personas.nombre', 'personas.apellidos', 'personas.cedula',  'personas.direccion',
                                    'personas.telefono',  'personas.celular',  'personas.email')
                        // ->orderBy('adopcion.id', 'desc')
                            ->where('adopcion.id','=',$id)->get(); 



        $pdf = \PDF::loadView('pdf.adopcion_pdf',['adopcion'=>$adopcion]);
        //->setPaper('a4', 'landscape');//formato horizontal

        //return $pdf->download('Receta de '.$diagnostico[0]->nombreMascota.'.pdf');          
        return $pdf->stream('Volante de adopcion de '.$adopcion[0]->nombreMascota.'.pdf');          
    }

    public function visualizarMascota(Request $request){//metodo vizualizar las mascotas en adopcion

        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                            //->join('users', 'personas.id', 'users.id')
                                ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.especie',
                                        'adopcion.raza', 'adopcion.fechaNacimiento', 'adopcion.edad', 
                                        'adopcion.observacion', 'adopcion.imagen', 'adopcion.estado',
                                        'personas.nombre', 'personas.apellidos', 
                                        'personas.telefono',  'personas.celular',   'personas.email' /*'users.email'*/)
                                ->orderBy('adopcion.id', 'desc')
                                ->where('adopcion.estado','=','1')->paginate(5);
                                //->where('adopcion.id','=',$id)->get(); 

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $adopcion->total(),
                'current_page' => $adopcion->currentPage(),
                'per_page'     => $adopcion->perPage(),
                'last_page'    => $adopcion->lastPage(),
                'from'         => $adopcion->firstItem(),
                'to'           => $adopcion->lastItem(),
            ],
            'adopcion' => $adopcion
        ];
    }

    /**Metodos usuario */

    public function indexUsuario(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
        
        if ($buscar==''){
            $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                   ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->where('personas.idUsuario', '=', $userID)
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        else{
            $adopcion =  Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                    ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->where('personas.idUsuario', '=', $userID)
                                    ->where($criterio, 'like', '%'. $buscar . '%')
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $adopcion->total(),
                'current_page' => $adopcion->currentPage(),
                'per_page'     => $adopcion->perPage(),
                'last_page'    => $adopcion->lastPage(),
                'from'         => $adopcion->firstItem(),
                'to'           => $adopcion->lastItem(),
            ],
            'adopcion' => $adopcion
        ];
    }


    /**Metodos cliente */

    public function indexCliente(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idPersona = \Auth::user()->idPersona;  ///obtengo el campo id del usuario autenticado
        
        if ($buscar==''){
            $adopcion = Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                   ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->where('personas.id', '=', $idPersona)
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        else{
            $adopcion =  Adopcion::join('personas', 'adopcion.idPersona', 'personas.id')
                                    ->select('adopcion.id', 'adopcion.idPersona', 'adopcion.nombreMascota', 'adopcion.fechaNacimiento', 
                                            'adopcion.edad', 'adopcion.especie', 'adopcion.estado',
                                            'personas.nombre', 'personas.apellidos', 'personas.idUsuario')
                                    ->where('personas.id', '=', $idPersona)
                                    ->where($criterio, 'like', '%'. $buscar . '%')
                                    ->orderBy('adopcion.id', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $adopcion->total(),
                'current_page' => $adopcion->currentPage(),
                'per_page'     => $adopcion->perPage(),
                'last_page'    => $adopcion->lastPage(),
                'from'         => $adopcion->firstItem(),
                'to'           => $adopcion->lastItem(),
            ],
            'adopcion' => $adopcion
        ];
    }




    

}
