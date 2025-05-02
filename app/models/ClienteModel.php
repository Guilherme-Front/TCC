<?php

class ClienteModel {
    private $pdo;

    public function __construct() {
        // Configure sua conexão com o banco de dados aqui
        $this->pdo = new PDO('mysql:host=localhost;dbname=pet_insight', 'root', '');
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>