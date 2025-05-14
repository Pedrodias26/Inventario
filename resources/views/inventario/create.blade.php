<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Inventário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Criar Novo Inventário</h2>
    <form action="{{ route('inventario.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Local da Contagem</label>
            <input type="text" name="local" class="form-control" required>
        </div>
        <button class="btn btn-success">Criar Inventário</button>
    </form>
</div>
</body>
</html>