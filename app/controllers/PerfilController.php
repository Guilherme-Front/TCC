<?php
require_once __DIR__ . '/conn.php';
session_start();

// Verifica se o cliente está logado
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
        header('Location: ../views/perfil.php');
        exit();
    }

    // Diretório da imagem do cliente
    $pastaCliente = '../../public/uploads/imgUsuarios/' . $id_cliente;

    // Cria o diretório se não existir
    if (!is_dir($pastaCliente)) {
        mkdir($pastaCliente, 0777, true);
    }

    // Verifica se uma nova foto foi enviada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Consulta a foto antiga
        $stmt = $conn->prepare("SELECT foto FROM cliente WHERE id_cliente = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($fotoAntiga);
        $stmt->fetch();
        $stmt->close();

        // Exclui a foto antiga se existir
        if (!empty($fotoAntiga)) {
            $caminhoAntigo = $pastaCliente . '/' . $fotoAntiga;
            if (file_exists($caminhoAntigo)) {
                unlink($caminhoAntigo);
            }
        }

        // Novo nome para a foto
        $nomeFoto = uniqid() . '-' . basename($_FILES['foto']['name']);
        $caminhoNovo = $pastaCliente . '/' . $nomeFoto;

        // Move o novo arquivo
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoNovo)) {
            $stmt = $conn->prepare("UPDATE cliente SET foto = ? WHERE id_cliente = ?");
            $stmt->bind_param("si", $nomeFoto, $id_cliente);
            $stmt->execute();
            $stmt->close();

            // Atualiza a sessão com a nova foto
            $_SESSION['foto_cliente'] = $nomeFoto;
            $_SESSION['sucesso'] = "Foto atualizada com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao salvar a nova foto.";
        }
    }

    // Campos do formulário
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

    // Converte a data para formato do MySQL
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $data_nasc, $matches)) {
        $data_mysql = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
    } else {
        $_SESSION['erro'] = 'Data de nascimento inválida!';
        header('Location: ../views/perfil.php');
        exit();
    }

    // Atualiza os dados no banco
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

// Acesso indevido via GET
header('Location: ../views/telaPerfil.php');
exit();
?>