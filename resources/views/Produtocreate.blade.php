@extends('layouts.app')

@section('title', 'Cadastrar Produto')

@section('content')
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
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Descrição</label>
            <input type="text" name="descricao" id="descricao" class="form-control">
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
            <input type="number" name="EAN" id="ean" class="form-control">
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eanInput = document.getElementById('ean');

        eanInput.addEventListener('change', function () {
            const ean = this.value;

            if (!ean) return;

            fetch(`https://brasilapi.com.br/api/mercadoria/v1/${ean}`)
                .then(response => {
                    if (!response.ok) throw new Error("Não encontrado");
                    return response.json();
                })
                .then(data => {
                    if (data && data.nome) {
                        document.getElementById('nome').value = data.nome;
                        document.getElementById('descricao').value = data.nome;
                    } else {
                        console.warn('API retornou, mas sem nome válido');
                    }
                })
                .catch(() => {
                    console.log('Produto não encontrado na BrasilAPI');
                });
        });
    });
</script>
@endpush
