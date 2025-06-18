@extends('layouts.app')

@section('title', 'Detalhes do Inventário')

@section('content')
    <h2>Inventário #{{ $inventario->id }}</h2>
    <p><strong>Local:</strong> {{ $inventario->local }}</p>
    <p><strong>Status:</strong> {{ ucfirst($inventario->status) }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('itens-inventario.create', $inventario->id) }}" class="btn btn-success mb-3">
        Contar Produto
    </a>

    {{-- Botão de lançamento --}}
    @if($inventario->itens->where('status', 'contado')->count() > 0 && $inventario->status === 'em_contagem')
        <form action="{{ route('inventario.lancar', $inventario->id) }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary">
                Lançar Inventário (Atualizar Estoque)
            </button>
        </form>
    @endif

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
                    <th>Descrição</th>
                    <th>Posição</th>
                    <th>Contada</th>
                    <th>Diferença</th>
                    <th>Validade</th>
                    <th>Valor Unitário</th>
                    <th>Valor da Diferença</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventario->itens as $item)
                    <tr>
                        <td>{{ $item->produto->codigo_interno ?? '—' }}</td>
                        <td>{{ $item->produto->EAN ?? '—' }}</td>
                        <td>{{ $item->produto->nome ?? 'Posição vazia' }}</td>
                        <td>{{ $item->produto->local_armazenamento ?? $item->local_contagem }}</td>
                        <td>{{ $item->quantidade_contada }}</td>
                        <td>{{ $item->diferenca }}</td>
                        <td>{{ $item->validade ?? '—' }}</td>
                        <td>R$ {{ number_format($item->valor_unitario ?? 0, 2, ',', '.') }}</td>
                        <td class="{{ $item->diferenca < 0 ? 'text-danger' : 'text-success' }}">
                            R$ {{ number_format(($item->diferenca ?? 0) * ($item->valor_unitario ?? 0), 2, ',', '.') }}
                        </td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Nenhum item contado ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection