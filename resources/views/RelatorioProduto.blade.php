@extends('layouts.app')

@section('title', 'Relatório de Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">
            <i class="bi bi-box-seam"></i> Relatório de Produtos
        </h2>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-house-door"></i> Página Inicial
            </a>
            <a href="{{ route('produtos.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Novo Produto
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Estilo local para diminuir a fonte da tabela e evitar quebra de linha -->
    <style>
        .table-sm th, .table-sm td {
            font-size: 0.80rem;
            padding: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px; /* ajuste conforme necessário */
        }
    </style>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>EAN</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Local</th>
                    <th>Lote</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->codigo_interno }}</td>
                        <td>{{ $produto->EAN }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                        <td>{{ $produto->local_armazenamento }}</td>
                        <td>{{ $produto->lote }}</td>
                        <td>{{ $produto->validade }}</td>
                        <td>{{ ucfirst($produto->status) }}</td>
                        <td>
                            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-sm btn-outline-primary mb-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
