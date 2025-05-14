<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página Inicial - Gerenciamento de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #333;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
        }

        .logout {
            margin-top: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bem-vindo ao Sistema</h2>
    <div class="btn-group">
        <a href="{{ route('produtos.index') }}" class="btn btn-primary"><i class="fa fa-box"></i> Relatório de Produtos</a>
        <a href="{{ route('inventario.index') }}" class="btn btn-success"><i class="fa fa-list"></i> Inventários</a>
        <a href="{{ route('inventario.create') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Criar Inventário</a>
        <a href="{{ route('GerenciamentoUsuario') }}" class="btn btn-info"><i class="fa fa-users"></i> Gerenciamento de Usuário</a>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="logout">
        @csrf
        <button type="submit" class="btn btn-danger w-100"><i class="fa fa-sign-out"></i> Sair</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>