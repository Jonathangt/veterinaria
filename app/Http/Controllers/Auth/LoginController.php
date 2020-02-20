<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $this->validateLogin($request);  
       // $this->updateLogin($request);      

        if (Auth::attempt(['email' => $request->email,
                        'password' => $request->password,
                        'estado'=>1])){
            return redirect()->route('home');
        }

        return back() //usuario--identificador del campo
        ->withErrors(['email' => trans('auth.failed')])//se mostrara un sms de error configurado en resources\lang\en\auth
        ->withInput(request(['email']));//retornara el usuario escrito en el input del login usuaio

    }

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

    }


}
