<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Empresa;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Processa o login do usuário
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Armazena o empresa_id do usuário logado na sessão
            session(['empresa_id' => $user->empresa_id]);

            // Redirecionamento baseado na role
            if ($user->role === 'auditor') {
                return redirect()->route('auditor.inventario');
            }

            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    /**
     * Exibe o formulário de registro
     */
    public function showRegisterForm()
    {
        $empresas = Empresa::all();

        return view('register', compact('empresas'));
    }

    /**
     * Processa o registro de um novo usuário
     */
    public function register(Request $request)
    {
        $temEmpresaSessao = session()->has('empresa_id');

        // Validação condicional
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,auditor',
            'empresa_id' => $temEmpresaSessao ? 'nullable' : 'required|exists:empresas,id',
        ]);

        // Pega o empresa_id da sessão ou do formulário
        $empresaId = $temEmpresaSessao ? session('empresa_id') : $request->empresa_id;

        // Cria o novo usuário vinculado à empresa
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'empresa_id' => $empresaId,
        ]);

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Realiza o logout do usuário
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
