<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Exibe a lista de usuários da empresa logada.
     */
    public function index()
    {
        $empresaId = session('empresa_id');

        $usuarios = User::where('empresa_id', $empresaId)->get();

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostra o formulário de edição de um usuário.
     */
    public function edit($id)
    {
        $empresaId = session('empresa_id');

        $usuario = User::where('empresa_id', $empresaId)->findOrFail($id);

        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Atualiza os dados de um usuário.
     */
    public function update(Request $request, $id)
    {
        $empresaId = session('empresa_id');

        $usuario = User::where('empresa_id', $empresaId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'role' => 'required|in:admin,auditor',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('GerenciamentoUsuario')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Remove um usuário da empresa.
     */
    public function destroy($id)
    {
        $empresaId = session('empresa_id');

        $usuario = User::where('empresa_id', $empresaId)->findOrFail($id);

        $usuario->delete();

        return redirect()->route('GerenciamentoUsuario')->with('success', 'Usuário excluído com sucesso.');
    }
}
