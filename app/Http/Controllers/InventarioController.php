<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Produto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('itens.produto')->get();
        return view('inventario.index', compact('inventarios'));
    }

    public function create()
    {
        return view('inventario.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'local' => 'required|string|max:255',
        ]);

        Inventario::create(['local' => $request->local]);

        return redirect()->route('inventario.index')->with('success', 'Inventário criado com sucesso.');
    }

    public function show(Inventario $inventario)
    {
        $inventario->load('itens.produto');
        return view('inventario.show', compact('inventario'));
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Inventário excluído.');
    }
}