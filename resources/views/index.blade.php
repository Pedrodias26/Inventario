<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Relatório de Produtos</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produtos.create') }}" class="btn btn-primary mb-3">Cadastrar Novo Produto</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Quantidade</th>
            <th>Local</th>
            <th>Lote</th>
            <th>Validade</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($produtos as $produto)
            <tr>
                <td>{{ $produto->codigo_interno }}</td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->descricao }}</td>
                <td>{{ $produto->quantidade }}</td>
                <td>{{ $produto->local_armazenamento }}</td>
                <td>{{ $produto->lote }}</td>
                <td>{{ $produto->validade }}</td>
                <td>{{ ucfirst($produto->status) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
