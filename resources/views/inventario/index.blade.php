@extends('layouts.app')

@section('title', 'Lista de Inventários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="text-primary">Lista de Inventários</h3>
    </div>
    @if(in_array(Auth::user()->role, ['admin', 'auditor']))
    <a href="{{ route('inventario.create') }}" class="btn btn-success">
        <i class="fa fa-plus-circle"></i> Novo Inventário
    </a>
    @endif
</div>

<form method="GET" action="{{ route('inventario.index') }}" class="mb-4 row g-3 align-items-center">
    <div class="col-auto">
        <label for="local" class="col-form-label">Filtrar por Local:</label>
    </div>
    <div class="col-auto">
        <input type="text" name="local" id="local" class="form-control"
               placeholder="Digite o local" value="{{ request('local') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> Filtrar
        </button>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover border text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Local</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventarios as $inv)
            <tr>
                <td>{{ $inv->id }}</td>
                <td>{{ $inv->local }}</td>
                <td>
                    <span class="badge {{ $inv->status === 'em_contagem' ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ ucfirst($inv->status) }}
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('inventario.show', $inv->id) }}">
                                    <i class="fa fa-eye text-primary"></i> Visualizar
                                </a>
                            </li>

                            @if(in_array(Auth::user()->role, ['admin', 'auditor']))
                                <li>
                                    @if($inv->status !== 'finalizado')
                                        <a class="dropdown-item" href="{{ route('itens-inventario.create', $inv->id) }}">
                                            <i class="fa fa-clipboard-check text-success"></i> Contar
                                        </a>
                                    @else
                                        <span class="dropdown-item disabled text-muted">
                                            <i class="fa fa-ban"></i> Contagem indisponível
                                        </span>
                                    @endif
                                </li>

                                @if($inv->status === 'em_contagem')
                                <li>
                                    <form action="{{ route('inventario.lancar', $inv->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fa fa-check-circle text-warning"></i> Lançar
                                        </button>
                                    </form>
                                </li>
                                @endif

                                <li>
                                    <form action="{{ route('inventario.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este inventário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa fa-trash"></i> Excluir
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Nenhum inventário encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
