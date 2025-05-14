<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Contagem de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Contagem de Produto - Inventário #{{ $inventario->id }}</h2>

    <form action="{{ route('itens-inventario.store', $inventario->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Local da Contagem</label>
            <input type="text" class="form-control" value="{{ $inventario->local }}" readonly>
        </div>

        <div class="mb-3">
            <label>Código do Produto</label>
            <input type="text" name="codigo_interno" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nova Quantidade</label>
            <input type="number" name="quantidade_contada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Validade</label>
            <input type="date" name="validade" class="form-control">
        </div>

        <button class="btn btn-success mt-3">Finalizar Contagem</button>
    </form>
</div>
</body>
</html>