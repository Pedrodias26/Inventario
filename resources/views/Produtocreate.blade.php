<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Cadastrar Produto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descrição</label>
            <input type="text" name="descricao" class="form-control">
        </div>
        <div class="mb-3">
            <label>Quantidade</label>
            <input type="number" name="quantidade" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Local de Armazenamento</label>
            <input type="text" name="local_armazenamento" class="form-control">
        </div>
        <div class="mb-3">
            <label>Lote</label>
            <input type="text" name="lote" class="form-control">
        </div>
        <div class="mb-3">
            <label>Validade</label>
            <input type="date" name="validade" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
</div>
</body>
</html>
