<?php
class LoginController {
    public function index() {
        require_once 'app/views/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];

            $userModel = new User();
            $user = $userModel->login($usuario, $senha);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header('Location: /login.php');
            } else {
                echo "Usuário ou senha inválidos.";
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['novo_usuario'];
            $senha = $_POST['nova_senha'];
            $email    = $_POST['novo_email'];

            $userModel = new User();
            if ($userModel->register($usuario, $senha, $email)) {
                echo "Usuário cadastrado com sucesso!";
                header('Location: /login.php');
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    }
}
?>
