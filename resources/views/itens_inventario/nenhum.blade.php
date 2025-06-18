@extends('layouts.app')

@section('title', 'Sem Inventários Pendentes')

@section('content')
<div class="container py-5 text-center">
    <h2 class="text-danger mb-3">📦 Nenhum Inventário Pendente</h2>
    <p class="lead">Todos os inventários foram contados. Favor revisar no monitor.</p>
    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Voltar ao Dashboard</a>
</div>
@endsection