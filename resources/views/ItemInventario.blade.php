@extends('ItemInventario')

@section('content')
<div class="container mt-4">
    <h2>Itens do Inventário</h2>

    <a href="{{ route('ItemInventario') }}" class="btn btn-primary mb-3">Adicionar Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Inventário</th>
                <th>Produto</th>
                <th>Registrado</th>
                <th>Contado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
                <tr>
                    <td>{{ $item->inventario->id ?? '-' }}</td>
                    <td>{{ $item->produto->nome ?? '-' }}</td>
                    <td>{{ $item->quantidade_registrada }}</td>
                    <td>{{ $item->quantidade_contada }}</td>
                    <td>
                        <a href="{{ route('itens-inventario.edit', $item->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('itens-inventario.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection