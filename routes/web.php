<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ItemInventarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;

// Rotas públicas
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {

    Route::get('/home', fn() => view('home'))->name('home');

    // Produtos
    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('index');
        Route::get('/create', [ProdutoController::class, 'create'])->name('create');
        Route::post('/', [ProdutoController::class, 'store'])->name('store');
    });

    // Inventário
    Route::resource('inventario', InventarioController::class);
    Route::post('inventario/{inventario}/lancar', [InventarioController::class, 'lancar'])->name('inventario.lancar');

    // Itens do Inventário (Contagem e ações diretas)
    Route::prefix('inventario/{inventario}')->group(function () {
        Route::get('/contar', [ItemInventarioController::class, 'create'])->name('itens-inventario.create'); // CORRIGIDO AQUI
        Route::post('/contar', [ItemInventarioController::class, 'store'])->name('itens-inventario.store');
    });
    Route::prefix('produtos')->name('produtos.')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('index');
        Route::get('/create', [ProdutoController::class, 'create'])->name('create');
        Route::post('/', [ProdutoController::class, 'store'])->name('store');

        // NOVAS ROTAS ABAIXO
        Route::get('/{id}/edit', [ProdutoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProdutoController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('destroy');
    });


    Route::get('/home', [HomeController::class, 'home'])->name('home');

    Route::post('itens-inventario/{item}/lancar', [ItemInventarioController::class, 'lancar'])->name('itens-inventario.lancar');
    Route::post('itens-inventario/{item}/cancelar', [ItemInventarioController::class, 'cancelar'])->name('itens-inventario.cancelar');

    // Gerenciamento de Usuários
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('GerenciamentoUsuario');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});
