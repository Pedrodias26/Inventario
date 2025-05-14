<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inventários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Inventários</h2>
    <a href="{{ route('inventario.create') }}" class="btn btn-success mb-3">Novo Inventário</a>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Local</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inv)
                <tr>
                    <td>{{ $inv->id }}</td>
                    <td>{{ $inv->local }}</td>
                    <td>{{ ucfirst($inv->status) }}</td>
                    <td>
                        <a href="{{ route('inventario.show', $inv->id) }}" class="btn btn-primary btn-sm">Ver Itens</a>
                        <form action="{{ route('inventario.destroy', $inv->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>