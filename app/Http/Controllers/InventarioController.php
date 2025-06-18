<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Produto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');

        $query = Inventario::with('itens.produto')
            ->where('empresa_id', $empresaId);

        if ($request->filled('local')) {
            $query->where('local', 'like', '%' . $request->local . '%');
        }

        $inventarios = $query->orderBy('id', 'desc')->get();

        $locais = Inventario::where('empresa_id', $empresaId)
            ->select('local')->distinct()->pluck('local');

        return view('inventario.index', compact('inventarios', 'locais'));
    }

    public function create()
    {
        $empresaId = session('empresa_id');

        $locais = Produto::where('empresa_id', $empresaId)
            ->select('local_armazenamento')
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
            'empresa_id' => session('empresa_id'),
        ]);

        return redirect()->route('inventario.index')->with('success', 'Inventário criado com sucesso.');
    }

    public function show(Inventario $inventario)
    {
        if ($inventario->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $inventario->load('itens.produto');

        return view('inventario.show', compact('inventario'));
    }

    public function destroy(Inventario $inventario)
    {
        if ($inventario->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $inventario->delete();

        return redirect()->route('inventario.index')->with('success', 'Inventário excluído.');
    }

    public function lancar(Inventario $inventario)
    {
        if ($inventario->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $itens = $inventario->itens()->where('status', 'contado')->get();

        if ($itens->isEmpty()) {
            return back()->with('error', 'Não há itens contados para lançar.');
        }

        foreach ($itens as $item) {
            $produto = $item->produto;

            // Atualiza dados do produto com os valores do item contado
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
