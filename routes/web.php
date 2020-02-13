<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Modulo Usuario 
Route::get('/users', 'UserController@index');
Route::post('/users/registrar', 'UserController@store');
Route::put('/users/actualizar', 'UserController@update');
Route::put('/users/desactivar', 'UserController@desactivar');
Route::put('/users/activar', 'UserController@activar');
Route::delete('/users/delete/{id}', 'UserController@destroy');


//Modulo registrar adopcion - personas 
Route::get('/personas', 'PersonasController@index');
Route::get('/personas/get_id', 'PersonasController@obtenerID');
Route::post('/personas/registrar', 'PersonasController@store');
Route::delete('/personas/delete/{id}', 'PersonasController@destroy');


//Modulo registrar adopcion - mascota 
Route::get('/mascotas', 'MascotasController@index');
Route::get('/mascotas/id', 'MascotasController@getMascota');/*ruta para obtener el id de la mascota en el registro
                                  de diagnostico  */
Route::get('/mascotas/personas', 'MascotasController@obtenerMascota');
Route::get('/mascotas/getMascota', 'MascotasController@obtenerMascotaID');


//Modulo donacion
Route::get('/donacion', 'DonacionesController@index');
Route::get('/donacion/mostrar', 'DonacionesController@mostrarDonacion');
Route::post('/donacion/registrar', 'DonacionesController@store');
Route::put('/donacion/actualizar', 'DonacionesController@update');
Route::get('/donacion/obtener', 'DonacionesController@obtenerDatos');
Route::delete('/donacion/delete/{id}', 'DonacionesController@destroy');
//Route::get('/donacion/estado', 'DonacionesController@obtenerEstado');
//Route::put('/donacion/desactivar', 'DonacionesController@desactivar');
//Route::put('/donacion/activar', 'DonacionesController@activar');