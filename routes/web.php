<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ItemInventarioController;

/**
 * Rotas públicas (login, registro)
 */
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * Rotas protegidas (requer autenticação)
 */
Route::middleware(['auth'])->group(function () {

    // Página Inicial
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    /**
     * Produtos
     */
    Route::prefix('produtos')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/create', [ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/', [ProdutoController::class, 'store'])->name('produtos.store');
    });

    /**
     * Gerenciamento de Usuário (poderia ter um controller específico futuramente)
     */
    Route::get('/GerenciamentoUsuario', function () {
        return view('usuarios.index');
    })->name('GerenciamentoUsuario');

    /**
     * Inventário
     */
    Route::resource('inventario', InventarioController::class);

    /**
     * Itens do Inventário (Contagem)
     */
    Route::prefix('inventario/{inventario}')->group(function () {
        Route::get('/contar', [ItemInventarioController::class, 'create'])->name('itens-inventario.create');
        Route::post('/contar', [ItemInventarioController::class, 'store'])->name('itens-inventario.store');
    });

    /**
     * Ações diretas em Itens do Inventário (Lançar, Cancelar)
     */
    Route::post('itens-inventario/{item}/lancar', [ItemInventarioController::class, 'lancar'])->name('itens-inventario.lancar');
    Route::post('itens-inventario/{item}/cancelar', [ItemInventarioController::class, 'cancelar'])->name('itens-inventario.cancelar');
});