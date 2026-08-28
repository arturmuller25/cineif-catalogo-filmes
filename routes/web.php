<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\PainelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Area publica: galeria de filmes (secao de usuario)
|--------------------------------------------------------------------------
*/
Route::get('/', [GaleriaController::class, 'index'])->name('galeria.index');
Route::get('/filme/{filme}', [GaleriaController::class, 'show'])->name('galeria.show');
Route::post('/filme/{filme}/avaliar', [AvaliacaoController::class, 'store'])->middleware('auth')->name('avaliacoes.store');

/*
|--------------------------------------------------------------------------
| Autenticacao
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/entrar', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/entrar', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/cadastrar', [AuthController::class, 'mostrarCadastro'])->name('register');
    Route::post('/cadastrar', [AuthController::class, 'cadastrar'])->name('register.submit');
});

Route::post('/sair', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Area administrativa (secao de administracao) - requer login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [PainelController::class, 'index'])->name('painel');

    Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes.index');
    Route::get('/filmes/novo', [FilmeController::class, 'create'])->name('filmes.create');
    Route::post('/filmes', [FilmeController::class, 'store'])->name('filmes.store');
    Route::get('/filmes/{filme}/editar', [FilmeController::class, 'edit'])->name('filmes.edit');
    Route::put('/filmes/{filme}', [FilmeController::class, 'update'])->name('filmes.update');
    Route::delete('/filmes/{filme}', [FilmeController::class, 'destroy'])->name('filmes.destroy');

    // Lixeira: recursos de soft delete (excluir, restaurar, apagar de vez)
    Route::get('/lixeira', [FilmeController::class, 'lixeira'])->name('filmes.lixeira');
    Route::put('/lixeira/{filme}/restaurar', [FilmeController::class, 'restaurar'])->withTrashed()->name('filmes.restaurar');
    Route::delete('/lixeira/{filme}', [FilmeController::class, 'forcarExclusao'])->withTrashed()->name('filmes.forcar');
});
