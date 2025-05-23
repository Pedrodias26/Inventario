@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary">Lista de Inventários</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-2">
                <i class="fa fa-arrow-left"></i> Voltar
            </a>
        </div>
        <a href="{{ route('inventario.create') }}" class="btn btn-success">
            <i class="fa fa-plus-circle"></i> Novo Inventário
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover border text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
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
                        <span class="badge 
                            {{ $inv->status === 'em_contagem' ? 'bg-warning text-dark' : 'bg-success' }}">
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
                                <li>
                                    <a class="dropdown-item" href="{{ route('itens-inventario.create', $inv->id) }}">
                                        <i class="fa fa-clipboard-check text-success"></i> Contar
                                    </a>
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
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa fa-trash"></i> Excluir
                                        </button>
                                    </form>
                                </li>
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
</div>
@endsection