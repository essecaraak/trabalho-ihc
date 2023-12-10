<?php

use App\Http\Controllers\dadosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
route::get('/relatorioPeso', [dadosController::class, 'obterDadosPeso'])->name('relatorioPeso');

Route::get('/exemple', function () {
    return view('exemple');
});
Route::get('/historicoPontos', function () {
    return view('historicoPontos');
});
Route::get('/historicoCalorias', function () {
    return view('historicoCalorias');
});
Route::get('/historicoPassos', function () {
    return view('historicoPassos');
});
Route::get('/historicoPeso', function () {
    return view('historicoPeso');
});