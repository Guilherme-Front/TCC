<?php
require_once 'Database.php';

class ClienteModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados) {
        $stmt = $this->db->prepare("
            UPDATE clientes 
            SET nome = :nome, 
                email = :email, 
                telefone = :telefone, 
                data_nascimento = :data_nascimento 
            WHERE id = :id
        ");
        
        return $stmt->execute($dados);
    }

    public function atualizarFoto($id, $caminhoFoto) {
        $stmt = $this->db->prepare("UPDATE clientes SET foto_perfil = :foto WHERE id = :id");
        $stmt->bindParam(':foto', $caminhoFoto);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>