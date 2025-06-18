<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Empresa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('{{ asset("images/bg-login.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 15px;
        }

        .register-box {
            background-color: rgba(33, 37, 41, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 400px;
            color: #fff;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ffc107;
            font-weight: 600;
            font-size: 24px;
        }

        .register-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background-color: #f8f9fa;
            color: #212529;
        }

        .register-box input::placeholder {
            color: #6c757d;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            background-color: #ffc107;
            color: #212529;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
        }

        .register-box button:hover {
            background-color: #e0a800;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .link {
            text-align: center;
            margin-top: 15px;
            color: #adb5bd;
        }

        .link a {
            color: #ffc107;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .icon-container {
            text-align: center;
            font-size: 60px;
            margin-bottom: 20px;
            color: #ffc107;
        }

        @media (max-width: 480px) {
            .register-box {
                padding: 30px 20px;
            }

            .register-box h2 {
                font-size: 20px;
            }

            .icon-container {
                font-size: 48px;
                margin-bottom: 15px;
            }

            .register-box button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-box">
        <div class="icon-container">
            <i class="fas fa-building"></i>
        </div>

        <h2>Cadastrar Empresa</h2>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('empresa.store') }}">
            @csrf
            <input type="text" name="razao_social" placeholder="Razão Social" value="{{ old('razao_social') }}" required>
            <input type="text" name="cnpj" placeholder="CNPJ" value="{{ old('cnpj') }}" required>
            <input type="text" name="endereco" placeholder="Endereço" value="{{ old('endereco') }}" required>
            <button type="submit"><i class="fas fa-check-circle"></i> Cadastrar Empresa</button>
        </form>

        <div class="link">
            <p>Já possui login? <a href="{{ route('login') }}">Entrar</a></p>
        </div>
    </div>
</body>
</html>
