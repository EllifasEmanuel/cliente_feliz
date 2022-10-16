<?php

use App\Http\Controllers\ExportPDFController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return redirect('/usuarios');
})->middleware('verified');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/usuarios',[UsuariosController::class, 'index'])->name('usuarios');
    Route::post('/create',[UsuariosController::class, 'create']);
    Route::get('/show',[UsuariosController::class, 'show']);
    Route::put('/update',[UsuariosController::class, 'update']);
    Route::delete('/remove',[UsuariosController::class, 'remove']);

    Route::get('/export',[ExportPDFController::class, 'generatePDF']);

    Route::get('/logout',[LoginController::class, 'destroy']);
});