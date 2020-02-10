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


//Modulo Usuario 
Route::get('/personas', 'PersonasController@index');
Route::get('/personas/get_id', 'PersonasController@obtenerID');
Route::post('/personas/registrar', 'PersonasController@store');
Route::delete('/personas/delete/{id}', 'PersonasController@destroy');