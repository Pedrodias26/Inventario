<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gerenciamento de Estoque</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #212529;
            padding-top: 30px;
            position: fixed;
            width: 240px;
            color: #fff;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            color: #adb5bd;
            display: flex;
            align-items: center;
            padding: 12px 25px;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 15px;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 18px;
        }

        .sidebar a:hover,
        .sidebar .active-link {
            background-color: #343a40;
            color: #ffffff;
        }

        .btn-logout {
            width: calc(100% - 50px);
            margin: 30px 25px 0 25px;
        }

        .content {
            margin-left: 240px;
            padding: 40px;
        }

        .card {
            border-left: 5px solid #198754;
            border-radius: 10px;
            background-color: #fff;
        }

        .card h5 {
            font-size: 20px;
            color: #198754;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 0;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>📦 Estoque</h4>
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active-link' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('produtos.index') }}" class="{{ request()->routeIs('produtos.*') ? 'active-link' : '' }}">
        <i class="bi bi-box-seam"></i> Relatório de Produtos
    </a>
    <a href="{{ route('inventario.index') }}" class="{{ request()->routeIs('inventario.*') ? 'active-link' : '' }}">
        <i class="bi bi-clipboard-data"></i> Inventário
    </a>
    <a href="{{ route('GerenciamentoUsuario') }}" class="{{ request()->routeIs('GerenciamentoUsuario') ? 'active-link' : '' }}">
        <i class="bi bi-people"></i> Usuários
    </a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-logout">
            <i class="bi bi-box-arrow-right"></i> Sair
        </button>
    </form>
</div>

<!-- Conteúdo -->
<div class="content">
    <h2 class="mb-4">Dashboard de Inventário</h2>

    <form method="GET" action="{{ route('home') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Data Inicial</label>
            <input type="date" name="start_date" class="form-control" value="{{ $dataInicio }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Data Final</label>
            <input type="date" name="end_date" class="form-control" value="{{ $dataFim }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h5>Inventários Criados</h5>
                <p><strong>{{ $inventariosCriados }}</strong></p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h5>Em Contagem</h5>
                <p><strong>{{ $emContagem }}</strong></p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <h5>Finalizados</h5>
                <p><strong>{{ $finalizados }}</strong></p>
            </div>
        </div>
    </div>

    @if(!$temDados)
        <div class="alert alert-warning">
            Nenhum dado encontrado para o período selecionado.
        </div>
    @endif

    <div class="chart-container">
        <h5>📊 Diferença de Quantidade</h5>
        <canvas id="graficoQuantidade"></canvas>
    </div>

    <div class="chart-container">
        <h5>📉 Diferença de Valor</h5>
        <canvas id="graficoValor"></canvas>
    </div>

    <div class="text-muted mt-3">
        Atualizado em: {{ now()->format('d/m/Y H:i') }}
    </div>
</div>

<!-- Gráficos -->
<script>
    const graficoQuantidade = new Chart(document.getElementById('graficoQuantidade'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Diferença de Quantidade',
                data: {!! json_encode($quantidades) !!},
                backgroundColor: 'rgba(25, 135, 84, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const graficoValor = new Chart(document.getElementById('graficoValor'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Diferença de Valor (R$)',
                data: {!! json_encode($valores) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
