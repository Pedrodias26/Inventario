@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container mb-5">
        <h2 class="text-center mb-4">Lista de Produtos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('produtos.create') }}" class="btn btn-success mb-3">Cadastrar Novo Produto</a>

        <!-- Estilo local para diminuir a fonte da tabela -->
        <style>
            .table-sm th, .table-sm td {
                font-size: 0.85rem;
                padding: 8px;
            }
        </style>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>EAN</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Status</th>
                        <th>Validade</th>
                        <th>Lote</th>
                        <th>Local</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                        <tr>
                            <td>{{ $produto->codigo_interno }}</td>
                            <td>{{ $produto->EAN }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td>{{ $produto->quantidade }}</td>
                            <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                            <td>{{ ucfirst($produto->status) }}</td>
                            <td>{{ $produto->validade }}</td>
                            <td>{{ $produto->lote }}</td>
                            <td>{{ $produto->local_armazenamento }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">Nenhum produto cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
