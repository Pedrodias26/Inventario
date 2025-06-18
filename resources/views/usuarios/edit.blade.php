@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Permissão de Usuário</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nome (visual e fixo) -->
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" class="form-control" value="{{ $usuario->name }}" disabled>
            <input type="hidden" name="name" value="{{ $usuario->name }}">
        </div>

        <!-- Email (visual e fixo) -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" class="form-control" value="{{ $usuario->email }}" disabled>
            <input type="hidden" name="email" value="{{ $usuario->email }}">
        </div>

        <!-- Permissão -->
        <div class="mb-3">
            <label for="role" class="form-label">Permissão</label>
            <select name="role" id="role" class="form-select" required>
                <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="auditor" {{ $usuario->role === 'auditor' ? 'selected' : '' }}>Auditor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar Alterações</button>
        <a href="{{ route('GerenciamentoUsuario') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
    </form>
</div>
@endsection
