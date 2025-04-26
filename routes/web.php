<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ReservaController;

// Página inicial (você pode depois mudar para outra view se quiser)
Route::get('/', function () {
    return view('welcome');
});

// Rotas para salas
Route::resource('salas', SalaController::class);

// Rotas para reservas
Route::resource('reservas', ReservaController::class);
