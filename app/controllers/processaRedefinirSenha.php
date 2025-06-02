<?php
session_start();
include_once "../controllers/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $novaSenha = $_POST['senha'];
    
    // Verificar se o e-mail existe no banco de dados
    $sql = "SELECT id_cliente FROM cliente WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
        $id_cliente = $cliente['id_cliente'];
        
        // Criptografar a nova senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        
        // Atualizar a senha na tabela de senhas
        $sqlUpdate = "UPDATE senha SET senha = '$senhaHash' WHERE id_cliente = '$id_cliente'";
        
        if ($conn->query($sqlUpdate)) {
            echo json_encode([
                'success' => true,
                'message' => 'Senha redefinida com sucesso! Você será redirecionado para fazer login.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao atualizar a senha no banco de dados.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'E-mail não encontrado em nosso sistema.'
        ]);
    }
    
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método de requisição inválido.'
    ]);
}
?>