<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Produto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::with('itens.produto');

        // Filtro por local
        if ($request->filled('local')) {
            $query->where('local', 'like', '%' . $request->local . '%');
        }

        $inventarios = $query->orderBy('id', 'desc')->get();

        // Locais únicos (para sugestões futuras)
        $locais = Inventario::select('local')->distinct()->pluck('local');

        return view('inventario.index', compact('inventarios', 'locais'));
    }

    public function create()
    {
        $locais = Produto::select('local_armazenamento')
            ->distinct()
            ->whereNotNull('local_armazenamento')
            ->pluck('local_armazenamento');

        return view('inventario.create', compact('locais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'local' => 'required|string|max:255',
        ]);

        Inventario::create([
            'local' => $request->local,
            'status' => 'em_contagem',
        ]);

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

    public function lancar(Inventario $inventario)
    {
        $itens = $inventario->itens()->where('status', 'contado')->get();

        if ($itens->isEmpty()) {
            return back()->with('error', 'Não há itens contados para lançar.');
        }

        foreach ($itens as $item) {
            $produto = $item->produto;
            $produto->quantidade = $item->quantidade_contada;
            $produto->local_armazenamento = $item->local_contagem;
            $produto->lote = $item->lote;
            $produto->validade = $item->validade;
            $produto->save();

            $item->status = 'lancado';
            $item->save();
        }

        $inventario->status = 'finalizado';
        $inventario->save();

        return back()->with('success', 'Inventário lançado e finalizado com sucesso.');
    }
}
