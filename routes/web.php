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

//Route::put('/users/actualizarCliente', 'UserController@updateCliente');
//Route::put('/users/actualizarUser', 'UserController@updateUser');

Route::put('/users/desactivar', 'UserController@desactivar');
Route::put('/users/activar', 'UserController@activar');
Route::delete('/users/delete/{id}', 'UserController@destroy');

//Ruta para el usuario
Route::get('/indexUsuario', 'UserController@indexUsuario');
Route::put('/users/actualizarUsuario', 'UserController@update'); //el admin usa el mismo metodo
Route::put('/users/actualizarUser', 'UserController@updateUsuarios');





//Modulo registrar clientes
Route::get('/clientes', 'ClientesController@index');
Route::post('/clientes/registrar', 'ClientesController@store');
Route::get('/clientes/obtener', 'ClientesController@obtener');
Route::get('/clientes/select-cliente', 'ClientesController@selectCliente');
Route::get('/clientes/select-cliente-id', 'ClientesController@selectPersonaID');
Route::put('/clientes/actualizar', 'ClientesController@update');
Route::delete('/clientes/delete/{id}', 'ClientesController@destroy');



//Modulo registrar mascotas
Route::get('/mascotass', 'MascotasController@index');
Route::post('/mascotas/registrar', 'MascotasController@store');
Route::get('/mascotas/obtener', 'MascotasController@obtener');
Route::put('/mascotas/actualizar', 'MascotasController@update');
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

Route::get('/prueba', 'InformacionController@prueba');


//Modulo informacion

Route::get('/infom', 'InformacionController@index');
Route::get('/informacion/obtener', 'InformacionController@obtenerDatos');
Route::get('/informacion/mostrarInformacion', 'InformacionController@informacionMostrar');
Route::post('/informacion/registrar', 'InformacionController@store');
Route::put('/informacion/actualizar', 'InformacionController@update');
Route::delete('/informacion/delete/{id}', 'InformacionController@destroy');

//Modulo consulta
Route::get('/consulta', 'ConsultaController@index');
Route::get('/consulta/obtener', 'ConsultaController@obtenerDatos');
Route::get('/consulta/select-cliente', 'ClientesController@selectCliente');
Route::get('/consulta/select-mascotas', 'ConsultaController@selectMascota');
Route::post('/consulta/registrar', 'ConsultaController@store');
Route::put('/consulta/actualizar', 'ConsultaController@update');
Route::delete('/consulta/delete/{id}', 'ConsultaController@destroy');
Route::get('/consulta/pdf/{id}', 'ConsultaController@pdfReceta');
Route::get('/consulta/mostrar-consulta', 'ConsultaController@obtenerDatos');
//ruta cliente
Route::get('/consultaCliente', 'ConsultaController@indexCliente');




/////Modulo adopcion
Route::get('/adopcion', 'AdopcionController@index');
Route::get('/adopcion/obtener', 'AdopcionController@obtener');
Route::get('/adopcion/vizualizar-mascota', 'AdopcionController@visualizarMascota');
Route::put('/adopcion/actualizar', 'AdopcionController@update');
Route::post('/adopcion/registrar', 'AdopcionController@store');
Route::put('/adopcion/desactivar', 'AdopcionController@desactivar');
Route::put('/adopcion/activar', 'AdopcionController@activar');
Route::get('/adopcion/pdf/{id}', 'AdopcionController@pdfAdocion');



//Modulo registrar datos para dar en adopcion
Route::get('/datos', 'DatosController@index');
Route::post('/datos/registrar', 'DatosController@store');
Route::get('/datos/obtener', 'DatosController@obtener');
Route::get('/datos/select-cliente', 'DatosController@selectPersona');
Route::get('/datos/select-cliente-id', 'DatosController@selectPersonaID');
Route::put('/datos/actualizar', 'DatosController@update');
Route::delete('/datos/delete/{id}', 'DatosController@destroy');

//rutas usuario
Route::get('/datosUser', 'DatosController@indexUsuario');
Route::post('/datos/registrarUser', 'DatosController@storeUsuario');




//Modulo registrar mascotas para dar en adopcion
Route::get('/adopcion', 'AdopcionController@index');
Route::post('/adopcion/registrar', 'AdopcionController@store');
Route::get('/adopcion/obtener', 'AdopcionController@obtener');
Route::get('/adopcion/select-datos', 'DatosController@selectDatos');
Route::delete('/adopcion/delete/{id}', 'AdopcionController@destroy');

//rutas usuario
Route::get('/adopcionUser', 'AdopcionController@indexUsuario');
Route::get('/adopcion/select-datos-user', 'DatosController@selectDatosUsuario');

//rutas cliente
Route::get('/adopcionCliente', 'AdopcionController@indexCliente');
Route::get('/adopcion/select-datos-cliente', 'DatosController@selectDatosCliente');












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