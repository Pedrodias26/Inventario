<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
        }

        .container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        .btn {
            padding: 8px 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .success {
            background: #d4edda;
            border-left: 5px solid #28a745;
            padding: 10px;
            margin-bottom: 20px;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Produtos</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('produtos.create') }}" class="btn">Cadastrar Novo Produto</a>

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Validade</th>
                    <th>Lote</th>
                    <th>Local</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtos as $produto)
                    <tr>
                        <td>{{ $produto->codigo_interno }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->descricao }}</td>
                        <td>{{ $produto->quantidade }}</td>
                        <td>{{ ucfirst($produto->status) }}</td>
                        <td>{{ $produto->validade }}</td>
                        <td>{{ $produto->lote }}</td>
                        <td>{{ $produto->local_armazenamento }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Nenhum produto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
