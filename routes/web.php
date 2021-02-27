<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PacienteLoginController@index');
Route::get('/cns/register', 'PacienteLoginController@create');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::resource('ubs', 'UbsController');
Route::resource('campanhas', 'CampanhasController');
Route::resource('pacientes', 'PacientesController');
Route::resource('campanhas-agendamentos', 'CampanhaAgendamentosController');


