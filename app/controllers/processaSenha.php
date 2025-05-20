<?php
header('Content-Type: application/json');
include '../controllers/conn.php';
session_start();

$response = ['success' => false, 'message' => 'Erro desconhecido'];

try {
    if (!isset($_SESSION['cadastro_temp'])) {
        throw new Exception("Dados de cadastro não encontrados. Complete o cadastro primeiro.");
    }

    if (empty($_POST['senha']) || empty($_POST['confirmar_senha'])) {
        throw new Exception("Preencha ambos os campos de senha.");
    }

    if ($_POST['senha'] !== $_POST['confirmar_senha']) {
        throw new Exception("As senhas não coincidem.");
    }

    // Inicia transação
    $conn->begin_transaction();

    // 1. Insere os dados do cliente
    $dados = $_SESSION['cadastro_temp'];
    $stmt = $conn->prepare("INSERT INTO cliente (nome, email, datNasc, telefone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $dados['nome'], $dados['email'], $dados['data'], $dados['telefone']);
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao cadastrar cliente: " . $stmt->error);
    }
    
    $id_cliente = $conn->insert_id;

    // 2. Insere a senha
    $hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO senha (id_cliente, senha) VALUES (?, ?)");
    $stmt->bind_param("is", $id_cliente, $hash);
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao cadastrar senha: " . $stmt->error);
    }

    // Confirma transação
    $conn->commit();
    
    // Limpa a sessão
    unset($_SESSION['cadastro_temp']);
    
    $response = [
        'success' => true,
        'message' => 'Cadastro concluído com sucesso!',
        'redirect' => '../views/Login.html'
    ];

} catch (Exception $e) {
    // Desfaz transação em caso de erro
    $conn->rollback();
    $response['message'] = $e->getMessage();
} finally {
    echo json_encode($response);
    exit();
}
?>