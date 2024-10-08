<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ActiveEventController;


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
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/criar', [ProductController::class, 'create'])->name('products.create');
        Route::get('/atualizar/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
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

    // Evento ativo
    Route::prefix('active-events')->group(function () {
        Route::post('/{event}/start', [ActiveEventController::class, 'startEvent'])->name('activeEvents.start');
        Route::post('/{id}/end', [ActiveEventController::class, 'endEvent'])->name('activeEvents.end');
        Route::post('/{id}/sell/{product}', [ActiveEventController::class, 'sellProduct'])->name('activeEvents.sell');
        Route::post('/{id}/add-expense', [ActiveEventController::class, 'addExpense'])->name('activeEvents.addExpense');
        Route::get('/{id}', [ActiveEventController::class, 'show'])->name('activeEvents.show');
    });


    
});