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
        ]);

        $produto->codigo_interno = str_pad($produto->id, 5, '0', STR_PAD_LEFT);
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }
}