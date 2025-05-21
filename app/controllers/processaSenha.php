<?php
header('Content-Type: application/json');
include '../controllers/conn.php';
session_start();

$id_cliente = $_SESSION['id_cliente'] ?? null;
$senha = $_POST['senha'];
$confirmar = $_POST['confirmar_senha'];

// Verifica se o ID do cliente está disponível
if (!$id_cliente) {
    die("Erro: id_cliente não encontrado na sessão. Cadastre o cliente primeiro.");
}

// Verifica se as senhas coincidem
if ($senha !== $confirmar) {
    die('Erro: As senhas não coincidem.');
}

// Criptografa a senha
$hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere a senha no banco
$stmt = $conn->prepare("INSERT INTO senha (id_cliente, senha) VALUES (?, ?)");
$stmt->bind_param("is", $id_cliente, $hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Senha cadastrada com sucesso.";
    $_SESSION['cadastro_concluido'] = false; // Marca que o cadastro foi concluído
    header("Location: ../views/Login.html"); // Redireciona para a página de login
    exit();
}
?>