*PerfilController.php*

<?php
require_once __DIR__ . '/conn.php';
session_start();

// Garante que o cliente está logado
$id_cliente = $_SESSION['id_cliente'] ?? null;
if (!$id_cliente) {
    header('Location: ../views/Login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação do token CSRF
    if (
        !isset($_POST['csrf_token']) ||
        !isset($_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $_SESSION['erro'] = 'Token de segurança inválido!';
        header('Location: ../views/telaPerfil.php');
        exit();
    }

    // Dados recebidos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $data_nasc = $_POST['data_nascimento'] ?? '';

    // Validação básica
    if (empty($nome) || empty($email) || empty($data_nasc)) {
        $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
        header('Location: ../views/telaPerfil.php');
        exit();
    }

    // Converte data de dd/mm/yyyy para yyyy-mm-dd
    $data_mysql = null;
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $data_nasc, $matches)) {
        $data_mysql = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
    } else {
        $_SESSION['erro'] = 'Data de nascimento inválida!';
        header('Location: ../views/telaPerfil.php');
        exit();
    }

    // Atualiza no banco
    try {
        $stmt = $conn->prepare("UPDATE cliente SET nome = ?, email = ?, telefone = ?, datNasc = ? WHERE id_cliente = ?");
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $data_mysql, $id_cliente);
        if ($stmt->execute()) {
            $_SESSION['sucesso'] = 'Dados atualizados com sucesso!';
        } else {
            $_SESSION['erro'] = 'Erro ao atualizar: ' . $stmt->error;
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['erro'] = 'Erro ao atualizar o banco de dados.';
    }

    header('Location: ../views/telaPerfil.php');
    exit();
}

// Se alguém acessar esse arquivo via GET, redireciona
header('Location: ../views/telaPerfil.php');
exit();