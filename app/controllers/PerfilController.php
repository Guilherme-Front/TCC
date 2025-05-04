<?php
require_once __DIR__ . '/conn.php';
session_start();

$id_cliente = $_SESSION['id_cliente'] ?? null;

// Protege contra acesso não autorizado
if (!$id_cliente) {
    header('Location: ../views/Login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['erro'] = 'Token de segurança inválido!';
        header('Location: ../controllers/PerfilController.php');
        exit();
    }

    // Coleta dos dados
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $data_nasc = $_POST['data_nascimento'] ?? '';

    // Validação simples
    if (empty($nome) || empty($email) || empty($data_nasc)) {
        $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
        header('Location: ../controllers/PerfilController.php');
        exit();
    }

    // Converte data para MySQL
    $data_mysql = null;
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $data_nasc, $matches)) {
        $data_mysql = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
    } else {
        $_SESSION['erro'] = 'Data inválida!';
        header('Location: ../controllers/PerfilController.php');
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
    } catch (Exception $e) {
        $_SESSION['erro'] = 'Erro no banco de dados: ' . $e->getMessage();
    }

    header('Location: ../controllers/PerfilController.php');
    exit();
}

// --- GET: busca dados e carrega view ---

// Pega os dados do banco
$stmt = $conn->prepare("SELECT nome, email, telefone, datNasc FROM cliente WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

// Formata data para o input
$dataNascFormatada = '';
if (!empty($cliente['datNasc']) && $cliente['datNasc'] != '0000-00-00') {
    $data = DateTime::createFromFormat('Y-m-d', $cliente['datNasc']);
    if ($data) {
        $dataNascFormatada = $data->format('d/m/Y');
    }
}

// Gera token CSRF se não existir
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Inclui a view com os dados
require_once __DIR__ . '/../views/telaPerfil.php';
