<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ItemInventarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RelatorioController;
use App\Models\Produto;

// ROTA PÚBLICA: Redireciona para login
Route::get('/', fn() => redirect()->route('login'));

// ROTAS DE AUTENTICAÇÃO
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ROTAS PROTEGIDAS (Necessita estar autenticado)
Route::middleware(['auth'])->group(function () {

    // DASHBOARD E RELATÓRIOS
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/relatorio/pdf', [RelatorioController::class, 'exportarPdf'])->name('relatorio.pdf');

    // BUSCA DE PRODUTO POR EAN
    Route::get('/produtos/buscar-por-ean/{ean}', function ($ean) {
        $produto = Produto::where('EAN', $ean)->first();

        if (!$produto) {
            return response()->json(['descricao' => null, 'quantidade' => 0], 404);
        }

        return response()->json([
            'descricao' => $produto->descricao,
            'quantidade' => $produto->quantidade,
        ]);
    });

    // ROTAS EXCLUSIVAS PARA ADMINISTRADOR
    Route::middleware('role:admin')->group(function () {

        // USUÁRIOS
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('GerenciamentoUsuario');
        Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        // PRODUTOS
        Route::prefix('produtos')->name('produtos.')->group(function () {
            Route::get('/', [ProdutoController::class, 'index'])->name('index');
            Route::get('/create', [ProdutoController::class, 'create'])->name('create');
            Route::post('/', [ProdutoController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProdutoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProdutoController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('destroy');
        });
    });

    // ROTAS PARA ADMIN E AUDITOR
    Route::middleware('role:admin,auditor')->group(function () {

        // INVENTÁRIOS
        Route::resource('inventario', InventarioController::class);
        Route::post('inventario/{inventario}/lancar', [InventarioController::class, 'lancar'])->name('inventario.lancar');

        // ITENS DO INVENTÁRIO
        Route::prefix('inventario/{inventario}')->group(function () {
            Route::get('/contar', [ItemInventarioController::class, 'create'])->name('itens-inventario.create');
            Route::post('/contar', [ItemInventarioController::class, 'store'])->name('itens-inventario.store');
        });

        // LANÇAR E CANCELAR ITEM CONTADO
        Route::post('itens-inventario/{item}/lancar', [ItemInventarioController::class, 'lancar'])->name('itens-inventario.lancar');
        Route::post('itens-inventario/{item}/cancelar', [ItemInventarioController::class, 'cancelar'])->name('itens-inventario.cancelar');

        // ACESSO DIRETO PARA AUDITOR → PRÓXIMO INVENTÁRIO
        Route::get('/auditor/inventario', [ItemInventarioController::class, 'proximoInventario'])->name('auditor.inventario');
    });
});