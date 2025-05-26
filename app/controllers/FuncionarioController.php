<?php
require_once __DIR__ . '/conn.php';
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['id_funcionario'])) {
    $_SESSION['toast'] = [
        'message' => 'Você precisa estar logado como funcionário para acessar esta página!',
        'type' => 'error'
    ];
    header('Location: ../views/Login.php');
    exit();
}

$id_funcionario = $_SESSION['id_funcionario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação do token CSRF
    if (
        empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) ||
        $_POST['csrf_token'] !== $_SESSION['csrf_token']
    ) {
        $_SESSION['toast'] = [
            'message' => 'Token de segurança inválido ou expirado!',
            'type' => 'error'
        ];
        header('Location: ../views/telaFuncionario.php');
        exit();
    }

    // Processamento do formulário
    $pastaFuncionario = '../../public/uploads/imgFuncionarios/' . $id_funcionario;

    // Cria diretório se não existir
    if (!is_dir($pastaFuncionario)) {
        mkdir($pastaFuncionario, 0777, true);
    }

    // Processa upload de foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Remove foto antiga se existir
        $stmt = $conn->prepare("SELECT foto FROM funcionario WHERE id_funcionario = ?");
        $stmt->bind_param("i", $id_funcionario);
        $stmt->execute();
        $stmt->bind_result($fotoAntiga);
        $stmt->fetch();
        $stmt->close();

        if (!empty($fotoAntiga)) {
            $caminhoAntigo = $pastaFuncionario . '/' . $fotoAntiga;
            if (file_exists($caminhoAntigo)) {
                unlink($caminhoAntigo);
            }
        }

        // Salva nova foto
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nomeFoto = uniqid() . '.' . $extensao;
        $caminhoNovo = $pastaFuncionario . '/' . $nomeFoto;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoNovo)) {
            $stmt = $conn->prepare("UPDATE funcionario SET foto = ? WHERE id_funcionario = ?");
            $stmt->bind_param("si", $nomeFoto, $id_funcionario);
            $stmt->execute();
            $stmt->close();
            $_SESSION['foto_funcionario'] = $nomeFoto;
        }
    }

    // Processa outros campos
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $data_nasc_br = $_POST['data_nascimento'] ?? '';
    $data_nasc = DateTime::createFromFormat('d/m/Y', $data_nasc_br)->format('Y-m-d');


    // Validação básica
    if (empty($nome) || empty($email) || empty($data_nasc)) {
        $_SESSION['toast'] = [
            'message' => 'Preencha todos os campos obrigatórios!',
            'type' => 'error'
        ];
        header('Location: ../views/telaFuncionario.php');
        exit();
    }

    // Atualiza dados
    try {
        $stmt = $conn->prepare("UPDATE funcionario SET nome=?, email=?, telefone=?, datNasc=? WHERE id_funcionario=?");
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $data_nasc, $id_funcionario);

        if ($stmt->execute()) {
            $_SESSION['toast'] = [
                'message' => 'Dados atualizados com sucesso!',
                'type' => 'success'
            ];
            // Atualiza dados na sessão
            $_SESSION['nome_funcionario'] = $nome;
            $_SESSION['email_funcionario'] = $email;
        } else {
            $_SESSION['toast'] = [
                'message' => 'Erro ao atualizar: ' . $stmt->error,
                'type' => 'error'
            ];
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'message' => 'Erro ao atualizar o banco de dados: ' . $e->getMessage(),
            'type' => 'error'
        ];
    }

    // Regenera o token CSRF após uso
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    header('Location: ../views/telaFuncionario.php');
    exit();
}

// Acesso indevido via GET
$_SESSION['toast'] = [
    'message' => 'Acesso inválido!',
    'type' => 'error'
];
header('Location: ../views/telaFuncionario.php');
exit();
?>