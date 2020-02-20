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
Route::put('/users/actualizarAdmin', 'UserController@updateAdmin');
Route::put('/users/actualizarCliente', 'UserController@updateCliente');
Route::put('/users/actualizarUser', 'UserController@updateUser');
Route::put('/users/desactivar', 'UserController@desactivar');
Route::put('/users/activar', 'UserController@activar');
Route::delete('/users/delete/{id}', 'UserController@destroy');


//Modulo registrar clientes
Route::get('/clientes', 'ClientesController@index');
Route::post('/clientes/registrar', 'ClientesController@store');
Route::get('/clientes/obtener', 'ClientesController@obtener');
Route::get('/clientes/select-cliente', 'ClientesController@selectPersona');
Route::get('/clientes/select-cliente-id', 'ClientesController@selectPersonaID');
Route::put('/clientes/actualizarAd', 'ClientesController@update');
Route::delete('/clientes/delete/{id}', 'ClientesController@destroy');

//Modulo registrar mascotas
Route::get('/mascotas', 'MascotasController@index');
Route::post('/mascotas/registrar', 'MascotasController@store');
Route::get('/mascotas/obtener', 'MascotasController@obtener');
Route::delete('/mascotas/delete/{id}', 'MascotasController@destroy');



//Modulo donacion
Route::get('/donacion', 'DonacionesController@index');
Route::post('/donacion/registrar', 'DonacionesController@store');
Route::put('/donacion/actualizar', 'DonacionesController@update');
Route::get('/donacion/obtener', 'DonacionesController@obtenerDatos');
Route::get('/donacion/mostrar-donacion', 'DonacionesController@mostrarDonacion');
Route::delete('/donacion/delete/{id}', 'DonacionesController@destroy');
//Route::get('/donacion/estado', 'DonacionesController@obtenerEstado');
//Route::put('/donacion/desactivar', 'DonacionesController@desactivar');
//Route::put('/donacion/activar', 'DonacionesController@activar');




Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});



//Modulo informacion
Route::get('/infom', 'InformacionController@index');
Route::get('/informacion/obtener', 'InformacionController@obtenerDatos');
Route::get('/informacion/mostrarInformacion', 'InformacionController@informacionMostrar');
Route::post('/informacion/registrar', 'InformacionController@store');
Route::put('/informacion/actualizar', 'InformacionController@update');
Route::delete('/informacion/delete/{id}', 'InformacionController@destroy');

//Modulo diagnostico
Route::get('/diagnostico', 'DiagnosticoController@index');
Route::get('/diagnostico/obtener', 'DiagnosticoController@obtenerDatos');
Route::get('/diagnostico/select-cliente', 'ClientesController@selectPersona');
Route::get('/diagnostico/select-mascotas', 'DiagnosticoController@selectMascota');
Route::post('/diagnostico/registrar', 'DiagnosticoController@store');
Route::put('/diagnostico/actualizar', 'DiagnosticoController@update');
Route::delete('/diagnostico/delete/{id}', 'DiagnosticoController@destroy');
Route::get('/diagnostico/pdf/{id}', 'DiagnosticoController@pdfReceta');
Route::get('/diagnostico/mostrar-consulta', 'DiagnosticoController@obtenerConsulta');
Route::get('/diagnostico/index-consulta', 'DiagnosticoController@indexConsulta');




/////Modulo adopcion
Route::get('/adopcion', 'AdopcionController@index');
Route::get('/adopcion/obtener', 'AdopcionController@obtenerDatos');
Route::get('/adopcion/vizualizar-mascota', 'AdopcionController@visualizarMascota');
Route::put('/adopcion/actualizar', 'AdopcionController@update');
Route::post('/adopcion/registrar', 'AdopcionController@store');
Route::put('/adopcion/desactivar', 'AdopcionController@desactivar');
Route::put('/adopcion/activar', 'AdopcionController@activar');


//Modulo registrar datos para dar en adopcion
Route::get('/datos', 'DatosController@index');
Route::post('/datos/registrar', 'DatosController@store');
Route::get('/datos/obtener', 'DatosController@obtener');
Route::get('/datos/select-cliente', 'DatosController@selectPersona');
Route::get('/datos/select-cliente-id', 'DatosController@selectPersonaID');
Route::put('/datos/actualizarAd', 'DatosController@updateAdmin');
Route::delete('/datos/delete/{id}', 'DatosController@destroy');


//Modulo registrar mascotas para dar en adopcion
Route::get('/adopcion', 'AdopcionController@index');
Route::post('/adopcion/registrar', 'AdopcionController@store');
Route::get('/adopcion/obtener', 'AdopcionController@obtener');
Route::get('/adopcion/select-datos', 'DatosController@selectDatos');
Route::delete('/adopcion/delete/{id}', 'AdopcionController@destroy');









/*
//Modulo registrar adopcion - personas 
Route::get('/personas', 'PersonasController@index');
Route::get('/personas/get_id', 'PersonasController@obtenerID');
Route::post('/personas/registrar', 'PersonasController@store');
Route::delete('/personas/delete/{id}', 'PersonasController@destroy');


//Route::get('/clientes/get_id', 'PersonasController@obtenerID');
Route::delete('/personas/delete/{id}', 'PersonasController@destroy');



//Modulo registrar adopcion - mascota 
//Route::get('/mascotas/obtener', 'MascotasController@obtenerDatos'); //Visualidar y editar
Route::delete('/mascotas/delete/{id}', 'MascotasController@destroy');



Route::get('/mascotas/personas', 'MascotasController@obtenerMascota');
Route::get('/mascotas/getMascota', 'MascotasController@obtenerMascotaID');
*/