<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login</title>

    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 300px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    input[type="text"],
    input[type="password"] {
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      padding: 10px;
      background-color:rgb(24, 100, 24);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover {
      background-color: #45a049;
    }
    #register-form {
      display: none;
    }
    .separator {
      text-align: center;
      margin: 20px 0;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Login</h2>
  <form id="login-form">
    <input type="text" placeholder="Usuário" required>
    <input type="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
  </form>

  <div class="separator"></div> 
  <button onclick="mostrarCadastro()">Cadastre-se</button>

  <form id="register-form">
    <h2>Cadastro</h2>
    <input type="text" placeholder="Novo Usuário" required>
    <input type="password" placeholder="Nova Senha" required>
    <input type="text" placeholder="Novo E-mail" required>
    <button type="submit">Cadastrar</button>
  </form>
</div>

<script>
  function mostrarCadastro() {
    const formCadastro = document.getElementById("register-form");
    formCadastro.style.display = formCadastro.style.display === "none" ? "flex" : "none";
  }
</script>

</body>
</html>
