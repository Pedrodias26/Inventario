<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Início - Gerenciamento de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <h2>Página Inicial</h2>
    <div class="btn-group">
        <a href="{{ route('produtos.create') }}" class="btn btn-success">Cadastrar Produto</a>
        <a href="{{ route('produtos.index') }}" class="btn btn-primary">Relatório de Produtos</a>
        <a href="#" class="btn btn-warning">Criar Inventário</a>
        <a href="#" class="btn btn-info" class="fa fa-file-excel-o">Relatórios</a>
        <button href="{{ route('GerenciamentoUsuario') }}" type="submit" class="btn btn-danger ">Gerenciamento de usuario <i class="fa fa-child"></i></button>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="logout">
        @csrf
        <button type="submit" class="btn btn-danger w-100">Sair</button>
    </form>
</div>
</body>
</html>
