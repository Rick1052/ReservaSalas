<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SalaController; // <-- Adicionei a importação do SalaController
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rota inicial
Route::get('/', function () {
    return redirect()->route('salas.index');  
});

// Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas (somente usuários logados)
Route::middleware('auth')->group(function () {

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROTAS DE SALAS
    Route::resource('salas', SalaController::class);

    // ROTAS DE RESERVAS
    Route::resource('reservas', ReservaController::class);
});

require __DIR__.'/auth.php';
