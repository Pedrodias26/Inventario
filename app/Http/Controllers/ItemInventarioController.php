<?php

namespace App\Http\Controllers;

use App\Models\ItemInventario;
use App\Models\Inventario;
use App\Models\Produto;
use Illuminate\Http\Request;

class ItemInventarioController extends Controller
{
    public function create(Inventario $inventario)
    {
        return view('itens_inventario.create', compact('inventario'));
    }

    public function store(Request $request, Inventario $inventario)
    {
        $request->validate([
            'EAN' => 'required|string',
            'quantidade_contada' => 'required|integer',
            'validade' => 'nullable|date',
        ]);

        $produto = Produto::where('EAN', $request->EAN)->firstOrFail();

        $diferenca = $request->quantidade_contada - $produto->quantidade;

        ItemInventario::create([
            'inventario_id' => $inventario->id,
            'produto_id' => $produto->id,
            'EAN' => $produto->EAN,
            'quantidade_contada' => $request->quantidade_contada,
            'diferenca' => $diferenca,
            'local_contagem' => $inventario->local,
            'validade' => $request->validade,
            'status' => 'contado',
            'valor_unitario' => $produto->valor_unitario, // CORRIGIDO AQUI
        ]);

        return redirect()->route('inventario.show', $inventario->id)->with('success', 'Contagem registrada.');
    }
}