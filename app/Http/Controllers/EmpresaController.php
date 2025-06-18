<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18',
            'endereco' => 'required|string|max:255',
        ]);

        $empresa = Empresa::create([
            'razao_social' => $request->razao_social,
            'cnpj' => $request->cnpj,
            'endereco' => $request->endereco,
        ]);

        session(['empresa_id' => $empresa->id]);

        return redirect()->route('register')->with('success', 'Empresa cadastrada com sucesso! Cadastre agora o usuário principal.');
    }
}
