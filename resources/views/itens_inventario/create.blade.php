@extends('layouts.app')

@section('title', 'Contagem de Produto')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="form-container">
            <h2 class="mb-4 text-center"><i class="bi bi-box-seam"></i> Contagem de Produto - Inventário {{ $inventario->id }}</h2>

            <form id="formContagem" action="{{ route('itens-inventario.store', $inventario->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Local da Contagem</label>
                    <input type="text" class="form-control bg-light" value="{{ $inventario->local }}" readonly>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="posicao_vazia" name="posicao_vazia">
                    <label class="form-check-label" for="posicao_vazia">Posição Vazia</label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-upc-scan me-1"></i>Código EAN</label>
                    <input type="text" name="EAN" class="form-control" placeholder="Digite ou escaneie o código EAN">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-card-text me-1"></i>Descrição do Produto</label>
                    <input type="text" id="descricao_produto" class="form-control bg-light" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-123 me-1"></i>Quantidade Esperada</label>
                    <input type="number" id="quantidade_esperada" name="quantidade_esperada" class="form-control bg-light" readonly value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-123 me-1"></i>Nova Quantidade Contada</label>
                    <input type="number" id="quantidade_contada" name="quantidade_contada" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-tag me-1"></i>Lote</label>
                    <input type="text" name="lote" id="lote" class="form-control" placeholder="Ex: L2345">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-calendar-check me-1"></i>Validade</label>
                    <input type="date" name="validade" id="validade" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Finalizar Contagem</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-white bg-success border-0" role="alert" data-bs-delay="3000" data-bs-autohide="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
@endif

<script>
    document.getElementById('posicao_vazia').addEventListener('change', function () {
        const disabled = this.checked;

        ['EAN', 'descricao_produto', 'quantidade_esperada', 'quantidade_contada', 'lote'].forEach(id => {
            const el = document.getElementsByName(id)[0] || document.getElementById(id);
            if (el) {
                el.disabled = disabled;
                if (disabled) el.value = '';
            }
        });

        document.getElementById('validade').required = !disabled;
    });

    document.querySelector('input[name="EAN"]').addEventListener('change', function () {
        const ean = this.value;

        fetch(`/produtos/buscar-por-ean/${ean}`)
            .then(response => {
                if (!response.ok) throw new Error("Produto não encontrado");
                return response.json();
            })
            .then(data => {
                document.getElementById('descricao_produto').value = data.descricao ?? 'Descrição não disponível';
                document.getElementById('quantidade_esperada').value = data.quantidade ?? 0;
            })
            .catch(() => {
                document.getElementById('descricao_produto').value = 'Produto não encontrado';
                document.getElementById('quantidade_esperada').value = 0;
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