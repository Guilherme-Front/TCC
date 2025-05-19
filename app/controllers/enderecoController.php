<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../views/Login.html');
    exit();
}

// Verifica o token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['erro'] = 'Token de segurança inválido.';
    header('Location: ../views/telaPerfil.php#endereco-section');
    exit();
}

// Função para limpar e validar dados
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Processa os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_SESSION['id_cliente'];
    $cep = sanitizeInput($_POST['cep']);
    $rua = sanitizeInput($_POST['rua']);
    $bairro = sanitizeInput($_POST['bairro']);
    $cidade = sanitizeInput($_POST['cidade']);
    $numero = isset($_POST['numero']) ? (int)sanitizeInput($_POST['numero']) : null;
    $complemento = isset($_POST['complemento']) ? sanitizeInput($_POST['complemento']) : null;

    // Remove hífen do CEP para armazenamento (12345-678 -> 12345678)
    $cep = str_replace('-', '', $cep);

    // Validações básicas
    $erros = [];
    
    if (empty($cep)) {
        $erros[] = 'CEP é obrigatório.';
    } elseif (!preg_match('/^\d{8}$/', $cep)) {
        $erros[] = 'CEP deve conter 8 dígitos.';
    }

    if (empty($rua)) {
        $erros[] = 'Rua é obrigatória.';
    } elseif (strlen($rua) < 3) {
        $erros[] = 'Rua deve ter pelo menos 3 caracteres.';
    }

    if (empty($bairro)) {
        $erros[] = 'Bairro é obrigatório.';
    }

    if (empty($cidade)) {
        $erros[] = 'Cidade é obrigatória.';
    }

    if ($numero !== null && ($numero < 1 || $numero > 9999)) {
        $erros[] = 'Número deve estar entre 1 e 9999.';
    }

    // Se houver erros, retorna para a página com mensagens
    if (!empty($erros)) {
        $_SESSION['erro'] = implode('<br>', $erros);
        $_SESSION['dados_endereco'] = $_POST; // Mantém os dados digitados
        header('Location: ../views/telaPerfil.php#endereco-section');
        exit();
    }

    try {
        // Verifica se já existe um endereço para este cliente
        $stmt = $conn->prepare("SELECT id_endereco FROM endereco WHERE id_cliente = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Atualiza o endereço existente
            $row = $result->fetch_assoc();
            $id_endereco = $row['id_endereco'];
            
            $stmt = $conn->prepare("UPDATE endereco SET 
                                  cep = ?, 
                                  bairro = ?, 
                                  rua = ?, 
                                  cidade = ?, 
                                  complemento = ?, 
                                  numero = ? 
                                  WHERE id_endereco = ?");
            $stmt->bind_param("sssssii", $cep, $bairro, $rua, $cidade, $complemento, $numero, $id_endereco);
        } else {
            // Insere um novo endereço
            $stmt = $conn->prepare("INSERT INTO endereco 
                                  (id_cliente, cep, bairro, rua, cidade, complemento, numero) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssi", $id_cliente, $cep, $bairro, $rua, $cidade, $complemento, $numero);
        }

        if ($stmt->execute()) {
            $_SESSION['sucesso'] = 'Endereço atualizado com sucesso!';
        } else {
            $_SESSION['erro'] = 'Erro ao salvar endereço. Tente novamente.';
        }
    } catch (Exception $e) {
        $_SESSION['erro'] = 'Erro no servidor: ' . $e->getMessage();
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }

    header('Location: ../views/telaPerfil.php#endereco-section');
    exit();
} else {
    header('Location: ../views/telaPerfil.php');
    exit();
}