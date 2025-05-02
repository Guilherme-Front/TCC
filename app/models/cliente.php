<?php

class Cliente {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getClienteById($id_cliente) {
        $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateCliente($id_cliente, $nome, $email, $telefone, $datNasc) {
        $sql = "UPDATE cliente 
                SET nome = ?, email = ?, telefone = ?, datNasc = ?
                WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $datNasc, $id_cliente);
        return $stmt->execute();
    }
}
?>
