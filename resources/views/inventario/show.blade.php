<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Inventário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Inventário #{{ $inventario->id }}</h2>
    <p><strong>Local:</strong> {{ $inventario->local }}</p>
    <p><strong>Status:</strong> {{ ucfirst($inventario->status) }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('itens-inventario.create', $inventario->id) }}" class="btn btn-success mb-3">Contar Produto</a>

    @if($inventario->itens->where('status', 'contado')->count() > 0 && $inventario->status == 'em_contagem')
        <form action="{{ route('inventario.lancar', $inventario->id) }}" method="POST" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary">Lançar Inventário</button>
        </form>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Contada</th>
                <th>Diferença</th>
                <th>Validade</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventario->itens as $item)
                <tr>
                    <td>{{ $item->produto->codigo_interno }}</td>
                    <td>{{ $item->produto->nome }}</td>
                    <td>{{ $item->quantidade_contada }}</td>
                    <td>{{ $item->diferenca }}</td>
                    <td>{{ $item->validade }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Nenhum item contado ainda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>