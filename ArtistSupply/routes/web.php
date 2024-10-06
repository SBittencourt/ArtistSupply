<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;

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

    Route::prefix('categorias')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });


    // Eventos
    Route::prefix('eventos')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('events.index');
        Route::get('/criar', [EventController::class, 'create'])->name('events.create');
        Route::post('/store', [EventController::class, 'store'])->name('events.store');
        Route::get('/{event}/editar', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

    // Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');
    });

    
});