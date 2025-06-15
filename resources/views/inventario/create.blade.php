@extends('layouts.app')

@section('title', 'Criar Inventário')

@section('content')
    <!-- Botão Voltar -->
    <div class="mb-4">
        <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary">
            ← Voltar para Inventários
        </a>
    </div>

    <!-- Card com formulário -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">Criar Novo Inventário</h2>
            <p class="text-muted">Selecione abaixo o local onde será realizada a contagem de inventário.</p>
            
            <form action="{{ route('inventario.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Local da Contagem</label>
                    <select name="local" class="form-select" required>
                        <option value="">Selecione o Local</option>
                        @foreach($locais as $local)
                            <option value="{{ $local }}">{{ $local }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Criar Inventário</button>
            </form>
        </div>
    </div>
@endsection
