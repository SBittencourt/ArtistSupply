<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;

//rota inicial
Route::get('/', function () {
    return view('index');
});

// login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Senha
Route::prefix('password')->group(function () {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Rotas autenticadas
Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [UserController::class, 'home'])->name('home');

    // Usuário
    Route::prefix('usuario')->group(function () {
        Route::get('/', [UserController::class, 'edit'])->name('usuario.atualizar');
        Route::post('/store', [UserController::class, 'store'])->name('usuario.store');
        Route::delete('/destroy', [UserController::class, 'destroy'])->name('usuario.excluir');
    });

    // Estoque
    Route::prefix('estoque')->group(function () {
        Route::get('/', [EstoqueController::class, 'index'])->name('produto.index');
        Route::get('/criar', [EstoqueController::class, 'create'])->name('produto.criar');
        Route::get('/atualizar', [EstoqueController::class, 'edit'])->name('produto.atualizar');
        Route::post('/store', [EstoqueController::class, 'store'])->name('produto.armazenar');
        Route::delete('/destroy', [EstoqueController::class, 'destroy'])->name('produto.excluir');
    });

    // Eventos
    Route::prefix('events')->group(function () {
        Route::get('/', [EventoController::class, 'index'])->name('evento.index');
        Route::get('/criar', [EventoController::class, 'create'])->name('evento.criar');
        Route::get('/atualizar', [EventoController::class, 'edit'])->name('evento.atualizar');
        Route::post('/store', [EventoController::class, 'store'])->name('evento.armazenar');
        Route::delete('/destroy', [EventoController::class, 'destroy'])->name('evento.excluir');
    });

    // Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('events.index');
    });

    
});