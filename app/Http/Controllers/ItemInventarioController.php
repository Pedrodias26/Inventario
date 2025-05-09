<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\ItemInventario;
use App\Models\Inventario;
use App\Models\Produto;
use Illuminate\Http\Request;

class ItemInventarioController extends Controller
{
    public function index()
    {
        $itens = ItemInventario::with('inventario', 'produto')->get();
        return view('itens_inventario.index', compact('itens'));
    }

    public function create()
    {
        $inventarios = ItemInventario::all();
        $produtos = Produto::all();
        return view('itens_inventario.create', compact('inventarios', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventario_id' => 'required|exists:inventarios,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade_registrada' => 'required|integer',
            'quantidade_contada' => 'required|integer',
        ]);

        ItemInventario::create($request->all());

        return redirect()->route('itens-inventario.index')->with('success', 'Item adicionado com sucesso.');
    }

    public function edit(ItemInventario $itens_inventario)
    {
        $inventarios = ItemInventario::all();
        $produtos = Produto::all();
        return view('itens_inventario.edit', [
            'item' => $itens_inventario,
            'inventarios' => $inventarios,
            'produtos' => $produtos,
        ]);
    }

    public function update(Request $request, ItemInventario $itens_inventario)
    {
        $request->validate([
            'inventario_id' => 'required|exists:inventarios,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade_registrada' => 'required|integer',
            'quantidade_contada' => 'required|integer',
        ]);

        $itens_inventario->update($request->all());

        return redirect()->route('itens-inventario.index')->with('success', 'Item atualizado com sucesso.');
    }

    public function destroy(ItemInventario $itens_inventario)
    {
        $itens_inventario->delete();
        return redirect()->route('itens-inventario.index')->with('success', 'Item deletado.');
    }
}