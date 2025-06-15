@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
    <h3 class="mb-4">Editar Produto</h3>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" class="mb-5">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ $produto->nome }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">EAN</label>
            <input type="number" name="EAN" class="form-control" value="{{ $produto->EAN }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" name="descricao" class="form-control" value="{{ $produto->descricao }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" value="{{ $produto->quantidade }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor Unitário</label>
            <input type="number" step="0.01" name="valor_unitario" class="form-control" value="{{ $produto->valor_unitario }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Local de Armazenamento</label>
            <input type="text" name="local_armazenamento" class="form-control" value="{{ $produto->local_armazenamento }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Lote</label>
            <input type="text" name="lote" class="form-control" value="{{ $produto->lote }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Validade</label>
            <input type="date" name="validade" class="form-control" value="{{ $produto->validade }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="ativo" {{ $produto->status == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ $produto->status == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
