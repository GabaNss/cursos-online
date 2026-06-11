<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscricaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cursos.index');
});

// Rotas que exigem autenticação — devem vir ANTES das rotas com {param}
Route::middleware('auth')->group(function () {
    Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

    Route::get('/inscricoes/create', [InscricaoController::class, 'create'])->name('inscricoes.create');
    Route::post('/inscricoes', [InscricaoController::class, 'store'])->name('inscricoes.store');
    Route::get('/inscricoes/{inscricao}/edit', [InscricaoController::class, 'edit'])->name('inscricoes.edit');
    Route::put('/inscricoes/{inscricao}', [InscricaoController::class, 'update'])->name('inscricoes.update');
    Route::delete('/inscricoes/{inscricao}', [InscricaoController::class, 'destroy'])->name('inscricoes.destroy');
});

// Rotas públicas — com {param} sempre depois das rotas fixas
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/inscricoes', [InscricaoController::class, 'index'])->name('inscricoes.index');

// Painel admin — exige autenticação + is_admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

require __DIR__.'/auth.php';
