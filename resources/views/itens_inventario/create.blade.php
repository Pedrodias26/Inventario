@extends('layouts.app')

@section('title', 'Contagem de Produto')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="form-container">
                <h2 class="mb-4 text-center"><i class="bi bi-box-seam"></i> Contagem de Produto - Inventário {{ $inventario->id }}</h2>

                <form action="{{ route('itens-inventario.store', $inventario->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Local da Contagem</label>
                        <input type="text" class="form-control bg-light" value="{{ $inventario->local }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upc-scan me-1"></i>Código EAN</label>
                        <input type="text" name="EAN" class="form-control" placeholder="Digite ou escaneie o código EAN" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-card-text me-1"></i>Descrição do Produto</label>
                        <input type="text" id="descricao_produto" class="form-control bg-light" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-123 me-1"></i>Nova Quantidade</label>
                        <input type="number" name="quantidade_contada" class="form-control" placeholder="Informe a quantidade contada" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-calendar-check me-1"></i>Validade</label>
                        <input type="date" name="validade" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Finalizar Contagem</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    Contagem registrada com sucesso!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        document.querySelector('input[name="EAN"]').addEventListener('change', function () {
            const ean = this.value;

            fetch(`/produtos/buscar-por-ean/${ean}`)
                .then(response => {
                    if (!response.ok) throw new Error("Produto não encontrado");
                    return response.json();
                })
                .then(data => {
                    document.getElementById('descricao_produto').value = data.descricao ?? 'Descrição não disponível';
                })
                .catch(() => {
                    document.getElementById('descricao_produto').value = 'Produto não encontrado';
                });
        });
    </script>
@endpush

@push('styles')
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #f1f8e9);
            font-family: 'Segoe UI', sans-serif;
        }
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: all 0.3s ease-in-out;
        }
        .form-container:hover {
            transform: scale(1.01);
        }
        .form-label {
            font-weight: 500;
        }
        .btn-success {
            font-size: 1.1rem;
        }
    </style>
@endpush
