<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Inventário</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
            color: #1d3557;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 6px;
            text-align: center;
        }

        th {
            background-color: #f3f3f3;
            font-weight: bold;
        }

        .diferenca {
            background-color: #fff3cd;
        }

        .justificativa {
            font-size: 12px;
            color: #6c757d;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Relatório de Inventário</h2>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Contado</th>
                <th>Esperado</th>
                <th>Diferença</th>
                <th>Data</th>
                <th>Justificativa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
            @php
                $esperado = $item->produto->quantidade ?? 0;
                $diferenca = $item->quantidade_contada - $esperado;
            @endphp
            <tr @if($diferenca !== 0) class="diferenca" @endif>
                <td>{{ $item->produto->nome }}</td>
                <td>{{ $item->quantidade_contada }}</td>
                <td>{{ $esperado }}</td>
                <td>{{ $diferenca }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td class="justificativa">
                    {{ $item->justificativa ?? '—' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
