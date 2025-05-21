<?php
require_once __DIR__ . '/conn.php';
session_start();

// Verifica se o cliente está logado
$id_cliente = $_SESSION['id_cliente'] ?? null;
if (!$id_cliente) {
    $_SESSION['toast'] = [
        'message' => 'Você precisa estar logado para acessar esta página!',
        'type' => 'error'
    ];
    header('Location: ../views/Login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação do token CSRF
    if (
        !isset($_POST['csrf_token']) ||
        !isset($_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $_SESSION['toast'] = [
            'message' => 'Token de segurança inválido!',
            'type' => 'error'
        ];
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
            $_SESSION['toast'] = [
                'message' => "Foto atualizada com sucesso!",
                'type' => 'success'
            ];
        } else {
            $_SESSION['toast'] = [
                'message' => "Erro ao salvar a nova foto.",
                'type' => 'error'
            ];
        }
    }

    // Campos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $data_nasc = $_POST['data_nascimento'] ?? '';

    // Validação básica
    if (empty($nome) || empty($email) || empty($data_nasc)) {
        $_SESSION['toast'] = [
            'message' => 'Preencha todos os campos obrigatórios!',
            'type' => 'error'
        ];
        header('Location: ../views/telaPerfil.php');
        exit();
    }

    // Converte a data para formato do MySQL
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $data_nasc, $matches)) {
        $data_mysql = "{$matches[3]}-{$matches[2]}-{$matches[1]}";
    } else {
        $_SESSION['toast'] = [
            'message' => 'Data de nascimento inválida!',
            'type' => 'error'
        ];
        header('Location: ../views/perfil.php');
        exit();
    }

    // Atualiza os dados no banco
    try {
        $stmt = $conn->prepare("UPDATE cliente SET nome = ?, email = ?, telefone = ?, datNasc = ? WHERE id_cliente = ?");
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $data_mysql, $id_cliente);
        if ($stmt->execute()) {
            $_SESSION['toast'] = [
                'message' => 'Dados atualizados com sucesso!',
                'type' => 'success'
            ];
        } else {
            $_SESSION['toast'] = [
                'message' => 'Erro ao atualizar: ' . $stmt->error,
                'type' => 'error'
            ];
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'message' => 'Erro ao atualizar o banco de dados.',
            'type' => 'error'
        ];
    }

    header('Location: ../views/telaPerfil.php');
    exit();
}

// Acesso indevido via GET
$_SESSION['toast'] = [
    'message' => 'Acesso inválido!',
    'type' => 'error'
];
header('Location: ../views/telaPerfil.php');
exit();
?>