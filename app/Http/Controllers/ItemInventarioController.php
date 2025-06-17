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
            'quantidade_esperada' => 'nullable|integer',
            'validade' => 'nullable|date',
            'justificativa' => 'nullable|string|max:1000',
        ]);

        $produto = Produto::where('EAN', $request->EAN)->firstOrFail();

        // Quantidade esperada baseada no produto real
        $quantidadeEsperada = $produto->quantidade;
        $quantidadeContada = (int) $request->quantidade_contada;
        $diferenca = $quantidadeContada - $quantidadeEsperada;

        // Se houver divergência e justificativa estiver vazia
        if ($quantidadeContada !== $quantidadeEsperada && empty($request->justificativa)) {
            return back()
                ->withInput()
                ->with('error', 'Justificativa obrigatória para contagem divergente.');
        }

        ItemInventario::create([
            'inventario_id' => $inventario->id,
            'produto_id' => $produto->id,
            'quantidade_contada' => $quantidadeContada,
            'diferenca' => $diferenca,
            'local_contagem' => $inventario->local,
            'validade' => $request->validade,
            'status' => 'contado',
            'valor_unitario' => $produto->valor_unitario,
            'justificativa' => $request->justificativa,
        ]);

        return redirect()
            ->route('inventario.show', $inventario->id)
            ->with('success', 'Contagem registrada com sucesso.');
    }
}
