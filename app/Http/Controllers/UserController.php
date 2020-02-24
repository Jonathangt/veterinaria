<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Personas;
use App\Http\Requests\StoreUsuarios;
use App\Http\Requests\UpdateUsuarios;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller{

    public function index(Request $request)    {
        if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $usuario = User::select('id','name','email','rol', 'estado', 'email_verified_at')
                            ->orderBy('id', 'desc')->paginate(10);
        }
        else{
            $usuario = User::select('id','name','email','rol',  'estado', 'email_verified_at')
                            ->where($criterio, 'like', '%'. $buscar . '%')
                            ->orderBy('name', 'desc')->paginate(10);
        }
        

        return [//atributos del objecto data para la paginacion
            'pagination' => [
                'total'        => $usuario->total(),
                'current_page' => $usuario->currentPage(),
                'per_page'     => $usuario->perPage(),
                'last_page'    => $usuario->lastPage(),
                'from'         => $usuario->firstItem(),
                'to'           => $usuario->lastItem(),
            ],
            'usuario' => $usuario
        ];
    }

    public function store(StoreUsuarios $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->rol = '1';//administrador
            $usuario->estado = '1'; //activo
            $usuario->password = bcrypt( $request->password);//el password se almacena encritado por seguridad
            $usuario->save();

    
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function updateAdmin(UpdateUsuarios $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();
            $usuario = User::findOrFail($request->id);
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->rol = '0';//Administrador
            $usuario->estado = '1'; //activo
            $usuario->password = bcrypt( $request->password);//el password se almacena encritado por seguridad
            $usuario->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function desactivar(Request $request) {
        if (!$request->ajax()) return redirect('/');
        $usuario = User::findOrFail($request->id);
        $usuario->estado = '0';
        $usuario->save();
    }

    public function activar(Request $request)  {
        if (!$request->ajax()) return redirect('/');
        $usuario = User::findOrFail($request->id);
        $usuario->estado = '1';
        $usuario->save();
    }

    public function destroy($id)  {

       /* $usuario = User::where("condicion", $id)->first();
        $persona = Personas::where("id", $usuario)->delete();
        $usuario = User::findOrFail($id)->delete();*/


        $usuario = User::findOrFail($id)->delete();

        /*//$cod = User::select('condicion')->where('id', '=', $id )->first();

        $cod = DB::table('users')->select('condicion')->where('condicion', '=', $id )->first();
        
       /* $persona = Personas::join('users', 'personas.idUsuario', 'users.id')
                        ->select('personas.id', 'users.condicion')
                        ->where('users.condicion', '=', $cod)
                        ->delete(); //elimino al usuario del cliente

                        $usuario = User::findOrFail($id)->delete();*/

       /* $personas = Personas::select('personas.id')
        ->where('id', '=', $cod)->delete();

        $usuario = User::findOrFail($id)->delete();*/

           
    } 

    /** */

    public function indexUsuario2(Request $request)    { //METODO PRUEBA 
       // if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax

        /*$userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado

        $usuario = User::where('id', '=', $userID)->paginate(10);       

        return ['usuario' => $usuario ];*/

        $ID = \Auth::user()->id;  ///obtengo el email de usuer


        $userID = \Auth::user()->email;  ///obtengo el email de usuer

        $usuario = Personas::select('id', 'email')
                        ->where('email', '=', $userID)->take(1)->get(10);    

        if (!$usuario) {
            return ['ID' => $ID];
        }else{
            return ['usuario' => $usuario];
        }


        

        //$personaEmail = Personas::findOrFail($request->usuarioEmail); //obtengo el email si esta en la tabla personas

    }

    public function indexUsuario(Request $request)    {
         if (!$request->ajax()) return redirect('/');//condicion para valiar los accesos mediante peticion ajax
 
         $userID = \Auth::user()->id;  ///obtengo el campo id del usuario autenticado
 
         $usuario = User::where('id', '=', $userID)->paginate(10);       
 
         return ['usuario' => $usuario ];
 
  
     }


    public function updateUsuario(Request $request)    {
        if (!$request->ajax()) return redirect('/');
        
        try{

            DB::beginTransaction();
            $usuario = User::findOrFail($request->id);

            $usuarioEmail = User::findOrFail($request->email); //obtengo el email

            $personaEmail = Personas::findOrFail($request->usuarioEmail); //obtengo el email si esta en la tabla personas

            if(!$personaEmail){
               
                $personaEmail->email = $request->email;
                $personaEmail->save(); 


                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->rol = '1';//USUARIO
                $usuario->estado = '1'; //activo
                $usuario->password = bcrypt( $request->password);//el password se almacena encritado por seguridad
                $usuario->save(); 


            }else{
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->rol = '1';//USUARIO
                $usuario->estado = '1'; //activo
                $usuario->password = bcrypt( $request->password);//el password se almacena encritado por seguridad
                $usuario->save(); 
            }

        /*    $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->rol = '1';//USUARIO
            $usuario->estado = '1'; //activo
            $usuario->password = bcrypt( $request->password);//el password se almacena encritado por seguridad
            $usuario->save();*/

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function prueba(Request $request)    {
       
        $usuario = User::findOrFail($request->id);

        $usuarioEmail = User::findOrFail($request->email); //obtengo el email

        //$personaEmail = Personas::findOrFail($request->usuarioEmail); //obtengo el email si esta en la tabla personas
           
            if(!$usuario){
                return ['usuario' => $usuario];
              

            }else{
                return ['usuarioEmail' => $usuarioEmail];
            }

      
    }
}
