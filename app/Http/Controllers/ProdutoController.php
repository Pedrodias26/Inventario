<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('Relatorioproduto', compact('produtos'));
    }

    public function create()
    {
        return view('Produtocreate');
    }

    public function store(Request $request)
    {
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
        ]);

        // Geração do código interno com 5 dígitos
        $produto->codigo_interno = str_pad($produto->id, 5, '0', STR_PAD_LEFT);
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
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

        $produto = Produto::findOrFail($id);
        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}