<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $empresaId = session('empresa_id');

        $produtos = Produto::where('empresa_id', $empresaId)->get();

        return view('Relatorioproduto', compact('produtos'));
    }

    public function create()
    {
        return view('Produtocreate');
    }

    public function store(Request $request)
    {
        $empresaId = session('empresa_id');

        $request->validate([
            'nome' => 'required|string|max:255',
            'EAN' => 'required|integer',
            'descricao' => 'nullable|string',
            'quantidade' => 'required|integer',
            'local_armazenamento' => 'nullable|string',
            'lote' => 'nullable|string',
            'validade' => 'nullable|date',
            'status' => 'required|in:ativo,inativo',
            'valor_unitario' => 'required|numeric',
        ]);

        $produto = Produto::create([
            'nome' => $request->nome,
            'EAN' => $request->EAN,
            'descricao' => $request->descricao,
            'quantidade' => $request->quantidade,
            'local_armazenamento' => $request->local_armazenamento,
            'lote' => $request->lote,
            'validade' => $request->validade,
            'status' => $request->status,
            'valor_unitario' => $request->valor_unitario,
            'empresa_id' => $empresaId,
        ]);

        $produto->codigo_interno = str_pad($produto->id, 5, '0', STR_PAD_LEFT);
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'EAN' => 'required|integer',
            'descricao' => 'nullable|string',
            'quantidade' => 'required|integer',
            'local_armazenamento' => 'nullable|string',
            'lote' => 'nullable|string',
            'validade' => 'nullable|date',
            'status' => 'required|in:ativo,inativo',
            'valor_unitario' => 'required|numeric',
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $itensRelacionados = $produto->itensInventario()->with('inventario')->get();

        foreach ($itensRelacionados as $item) {
            if ($item->inventario && $item->inventario->status !== 'finalizado') {
                return redirect()->route('produtos.index')
                    ->with('error', 'Produto vinculado a inventário em andamento. Não pode ser excluído.');
            }
        }

        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
