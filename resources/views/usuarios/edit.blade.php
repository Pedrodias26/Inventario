@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Permissão de Usuário</h2>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" class="form-control" value="{{ $usuario->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" class="form-control" value="{{ $usuario->email }}" disabled>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Permissão</label>
            <select name="role" id="role" class="form-select" required>
                <option value="usuario" {{ $usuario->role === 'usuario' ? 'selected' : '' }}>Usuário</option>
                <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('GerenciamentoUsuario') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
