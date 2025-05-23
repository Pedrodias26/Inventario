<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">
                <i class="bi bi-box-seam"></i> Cadastrar Produto
            </h2>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar à Página Inicial
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produtos.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Descrição</label>
                    <input type="text" name="descricao" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantidade</label>
                    <input type="number" name="quantidade" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Valor Unitário (R$)</label>
                    <input type="number" step="0.01" name="valor_unitario" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Local de Armazenamento</label>
                    <input type="text" name="local_armazenamento" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lote</label>
                    <input type="text" name="lote" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Validade</label>
                    <input type="date" name="validade" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Código EAN</label>
                    <input type="number" name="EAN" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Cadastrar Produto
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
