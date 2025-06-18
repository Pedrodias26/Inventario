<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Logística</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('{{ asset("images/bg-login.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .login-box {
            background-color: rgba(33, 37, 41, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 360px;
            color: #fff;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ffc107;
            font-weight: 600;
            font-size: 24px;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background-color: #f8f9fa;
            color: #212529;
        }

        .login-box input::placeholder {
            color: #6c757d;
        }

        .login-box button {
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

        .login-box button:hover {
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

        .btn-empresa {
            display: block;
            margin-top: 10px;
            background-color: transparent;
            color: #ffc107;
            border: 1px solid #ffc107;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-empresa:hover {
            background-color: #ffc107;
            color: #212529;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
                align-items: flex-start;
            }

            .login-box {
                padding: 30px 20px;
                border-radius: 10px;
                margin-top: 60px;
            }

            .login-box h2 {
                font-size: 20px;
            }

            .icon-container {
                font-size: 48px;
                margin-bottom: 15px;
            }

            .login-box button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="icon-container">
        <i class="fas fa-warehouse"></i>
    </div>

    <h2>Sistema de Estoque</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="E-mail corporativo" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Senha de acesso" required>
        <button type="submit"><i class="fa fa-sign-in-alt"></i> Entrar</button>
    </form>

    <div class="link">
        <p>Não possui login? <a href="{{ route('register') }}">Registrar-se</a></p>
        <a href="{{ route('empresa.create') }}" class="btn-empresa"><i class="fas fa-building"></i> Cadastrar Empresa</a>
    </div>
</div>
</body>
</html>
