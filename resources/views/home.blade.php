<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gerenciamento de Estoque</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            width: 220px;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 220px;
            padding: 30px;
        }
        .card {
            border-left: 4px solid #198754;
        }
        .card h5 {
            font-size: 20px;
        }
        .card p {
            font-size: 16px;
        }
        .btn-logout {
            width: 100%;
            margin-top: 20px;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4 class="text-center">Menu</h4>
    <a href="{{ route('home') }}">Dashboard</a>
    <a href="{{ route('produtos.index') }}">Relatorio de Produtos</a>
    <a href="{{ route('inventario.index') }}">Inventario</a>
    <a href="{{ route('inventario.create') }}">Criar Inventario</a>
    <a href="{{ route('GerenciamentoUsuario') }}">Usuarios</a>
    <form action="{{ route('logout') }}" method="POST" class="mt-4 px-3">
        @csrf
        <button type="submit" class="btn btn-danger btn-logout">Sair</button>
    </form>
</div>

<div class="content">
    <h2 class="mb-4">Dashboard de Inventario</h2>

    <form method="GET" action="{{ route('home') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Data Inicial</label>
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <label>Data Final</label>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow p-3">
                <h5>Inventario Criados</h5>
                <p><strong>{{ $inventariosCriados }}</strong></p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow p-3">
                <h5>Em Contagem</h5>
                <p><strong>{{ $emContagem }}</strong></p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow p-3">
                <h5>Finalizados</h5>
                <p><strong>{{ $finalizados }}</strong></p>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <h5>Grafico de Diferença de Quantidade</h5>
        <canvas id="graficoQuantidade"></canvas>
    </div>

    <div class="chart-container">
        <h5>Grafico de Diferença de Valor</h5>
        <canvas id="graficoValor"></canvas>
    </div>

    <div class="text-muted">
        Atualizado em: {{ now()->format('d/m/Y H:i') }}
    </div>
</div>

<script>
    const graficoQuantidade = new Chart(document.getElementById('graficoQuantidade'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Diferença de Quantidade',
                data: {!! json_encode($quantidades) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    });

    const graficoValor = new Chart(document.getElementById('graficoValor'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Diferença de Valor (R$)',
                data: {!! json_encode($valores) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }]
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>