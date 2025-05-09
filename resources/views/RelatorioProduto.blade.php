<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">
            <i class="bi bi-box-seam"></i> Relatório de Produtos
        </h2>
        <div>
            <a href="{{ route('home') }}" class="btn btn-secondary me-2">Voltar para a Pagina inicial</a>
            <a href="{{ route('produtos.create') }}" class="btn btn-success">Cadastrar Novo Produto</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
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
</div>

<!-- Ícones do Bootstrap (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
</body>
</html>