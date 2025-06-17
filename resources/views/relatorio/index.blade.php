@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-xl font-bold mb-4">Relatório de Inventário</h2>

    <form method="GET" action="{{ route('relatorio.index') }}" class="mb-4 flex flex-wrap gap-4">
        <input type="text" name="produto" placeholder="Produto" class="border p-2 rounded" value="{{ request('produto') }}">
        <input type="date" name="data_inicio" class="border p-2 rounded" value="{{ request('data_inicio') }}">
        <input type="date" name="data_fim" class="border p-2 rounded" value="{{ request('data_fim') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
        <a href="{{ route('relatorio.pdf', request()->all()) }}" class="bg-red-500 text-white px-4 py-2 rounded">Exportar PDF</a>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full border text-sm text-left">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">Produto</th>
                    <th class="border px-2 py-1">Contado</th>
                    <th class="border px-2 py-1">Esperado</th>
                    <th class="border px-2 py-1">Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itens as $item)
                <tr>
                    <td class="border px-2 py-1">{{ $item->produto->nome }}</td>
                    <td class="border px-2 py-1">{{ $item->quantidade_contada }}</td>
                    <td class="border px-2 py-1">{{ $item->quantidade_esperada }}</td>
                    <td class="border px-2 py-1">{{ $item->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="border px-2 py-4 text-center text-gray-500">Nenhum item encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $itens->links() }}
    </div>
</div>
@endsection
