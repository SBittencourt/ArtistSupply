<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ActiveEventController;
use App\Http\Controllers\Api\RelatorioController;

Route::prefix('api')->group(function () {
    // Rotas de autenticação para API
    Route::prefix('auth')->group(function () {
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:api');
        Route::post('register', [RegisterController::class, 'register']);

        // Senha
        Route::prefix('password')->group(function () {
            Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
            Route::post('reset', [ResetPasswordController::class, 'reset'])->name('password.update');
        });
    });

    // Rotas protegidas por autenticação

        // Home
        Route::prefix('home')->group(function () {
            Route::get('/', [UserController::class, 'home']);
        });
        // Usuário
        Route::prefix('usuario')->group(function () {
            Route::get('/', [UserController::class, 'edit']);
            Route::post('/store', [UserController::class, 'store']);
            Route::delete('/destroy', [UserController::class, 'destroy']);
        });

        // Produtos
        Route::prefix('estoque')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/create', [ProductController::class, 'create']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::put('/update/{id}', [ProductController::class, 'update']);
            Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
        });

        // Categorias
        Route::prefix('categorias')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });

        // Eventos
        Route::prefix('eventos')->group(function () {
            Route::get('/', [EventController::class, 'index']);
            Route::post('/store', [EventController::class, 'store']);
            Route::put('/{event}', [EventController::class, 'update']);
            Route::delete('/{event}', [EventController::class, 'destroy']);
        });

        // Relatórios
        Route::get('relatorios', [RelatorioController::class, 'index']);

        // Eventos ativos
        Route::prefix('active-events')->group(function () {
            Route::get('/', [ActiveEventController::class, 'index']);
            Route::post('/{event}/start', [ActiveEventController::class, 'startEvent']);
            Route::post('/{id}/end', [ActiveEventController::class, 'endEvent']);
            Route::post('/{activeEventId}/sell/{productId}', [ActiveEventController::class, 'sellProduct']);
            Route::post('/{id}/add-expense', [ActiveEventController::class, 'addExpense']);
            Route::get('/{id}', [ActiveEventController::class, 'show']);
            Route::get('/{activeEventId}/summary', [ActiveEventController::class, 'summary']);
            Route::delete('/{id}/delete', [ActiveEventController::class, 'destroy']);
        });
    });
