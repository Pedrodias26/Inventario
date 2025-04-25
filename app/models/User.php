<?php
class User {
    private $conn;

    public function __construct() {
        require_once 'config/config.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function register($username, $password) {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }
}
?>
