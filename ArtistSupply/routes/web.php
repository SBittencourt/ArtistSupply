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
        Route::get('/', [])->name('usuario.index');
        Route::get('/atualizar', [])->name('usuario.atualizar');
        Route::post('/store', [])->name('usuario.armazenar');
        Route::delete('/destroy', [])->name('usuario.excluir');
        });


    // Estoque
    Route::prefix('estoque')->group(function () {
        Route::get('/', [])->name('produto.index');
        Route::get('/criar', [])->name('produto.criar');
        Route::get('/atualizar', [])->name('produto.atualizar');
        Route::post('/store', [])->name('produto.armazenar');
        Route::delete('/destroy', [])->name('produto.excluir');
        });

    // Eventos
    Route::prefix('events')->group(function () {
        Route::get('/', [])->name('evento.index');
        Route::get('/criar', [])->name('evento.criar');
        Route::get('/atualizar', [])->name('evento.atualizar');
        Route::post('/store', [])->name('evento.armazenar');
        Route::delete('/destroy', [])->name('evento.excluir');
        });
    
    // Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/', [])->name('events.index');

        });
    
});