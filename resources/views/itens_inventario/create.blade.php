<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Essencial para responsividade -->
    <title>Contagem de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="mb-4 text-center">Contagem de Produto - Inventário #{{ $inventario->id }}</h2>

            <form action="{{ route('itens-inventario.store', $inventario->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Local da Contagem</label>
                    <input type="text" class="form-control" value="{{ $inventario->local }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Código EAN</label>
                    <input type="text" name="EAN" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nova Quantidade</label>
                    <input type="number" name="quantidade_contada" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Validade</label>
                    <input type="date" name="validade" class="form-control">
                </div>

                <div class="d-grid">
                    <button class="btn btn-success">Finalizar Contagem</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
