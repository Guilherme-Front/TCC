<?php
require_once __DIR__ . '/../controllers/conn.php';

session_start();

// Verificações iniciais
if (!isset($_SESSION['id_cliente']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/Login.html');
    exit();
}

// Validação do CSRF Token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['erro'] = 'Token de segurança inválido!';
    header('Location: ../views/telaperfil.php');
    exit();
}

// Processamento dos dados
$id_cliente = $_SESSION['id_cliente'];
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? ''); // Remove não numéricos
$data_nasc = $_POST['data_nascimento'] ?? '';

// Validações básicas
if (empty($nome) || empty($email) || empty($data_nasc)) {
    $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
    header('Location: ../views/telaperfil.php');
    exit();
}

// Conversão da data (DD/MM/YYYY → YYYY-MM-DD)
$data_mysql = null;
if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $data_nasc, $matches)) {
    $data_mysql = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
}

if (!$data_mysql) {
    $_SESSION['erro'] = 'Formato de data inválido! Use DD/MM/AAAA';
    header('Location: ../views/telaperfil.php');
    exit();
}

// Atualização no banco
try {
    $stmt = $conn->prepare("UPDATE cliente SET nome = ?, email = ?, telefone = ?, datNasc = ? WHERE id_cliente = ?");
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $data_mysql, $id_cliente);
    
    if ($stmt->execute()) {
        $_SESSION['sucesso'] = 'Dados atualizados com sucesso!';
    } else {
        $_SESSION['erro'] = 'Erro ao atualizar: ' . $stmt->error;
    }
} catch (Exception $e) {
    $_SESSION['erro'] = 'Erro no banco de dados: ' . $e->getMessage();
}

// Redirecionamento
header('Location: ../controllers/AtualizarPerfilController.php');
exit();
?>