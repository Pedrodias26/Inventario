<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Estoque')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #212529;
            padding-top: 30px;
            position: fixed;
            width: 240px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #ffffff;
        }

        .sidebar a {
            color: #adb5bd;
            display: flex;
            align-items: center;
            padding: 12px 25px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            font-size: 15px;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #343a40;
            color: #ffffff;
        }

        .content {
            margin-left: 240px;
            padding: 30px;
        }

        .btn-logout {
            width: calc(100% - 50px);
            margin: 30px 25px 0 25px;
        }

        .active-link {
            background-color: #343a40;
            color: #ffffff !important;
        }

        /* Oculta a sidebar em dispositivos móveis */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0 !important;
                padding: 20px;
            }
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

<!-- Conteúdo da Página -->
<div class="content">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>