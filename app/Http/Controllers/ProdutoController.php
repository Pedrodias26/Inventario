<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produtos', compact('produtos'));
    }

    public function create()
    {
        return view('Produtocreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'quantidade' => 'required|integer',
            'local_armazenamento' => 'nullable|string',
            'lote' => 'nullable|string',
            'validade' => 'nullable|date',
            'status' => 'required|in:ativo,inativo',
        ]);

        $produto = new Produto();
        $produto->codigo_interno = uniqid('PROD-');
        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->quantidade = $request->quantidade;
        $produto->local_armazenamento = $request->local_armazenamento;
        $produto->lote = $request->lote;
        $produto->validade = $request->validade;
        $produto->status = $request->status;
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }
}
