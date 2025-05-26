<?php
session_start();
include_once "../controllers/conn.php";

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $senhaDigitada = $_POST['senha'];

    // Verifica funcionário
    $sql_funcionario = "SELECT id_funcionario, nome, email, senha, datNasc, telefone 
                       FROM funcionario WHERE email = '$email'";
    $result_func = $conn->query($sql_funcionario);

    if ($result_func && $result_func->num_rows > 0) {
        $func = $result_func->fetch_assoc();

        if ($senhaDigitada === $func['senha']) {
            $_SESSION['id_funcionario'] = $func['id_funcionario'];
            $_SESSION['nome_funcionario'] = $func['nome'];
            $_SESSION['email_funcionario'] = $func['email'];

            // Gera novo token CSRF para a sessão
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $_SESSION['toast'] = [
                'message' => 'Login de funcionário realizado com sucesso! Bem-vindo, ' . htmlspecialchars($func['nome']) . '! 👋',
                'type' => 'success'
            ];

            header("Location: ../views/Index.php");
            exit();
        } else {
            $_SESSION['toast'] = [
                'message' => 'Senha de funcionário incorreta. Tente novamente! 🔒',
                'type' => 'error'
            ];
            header("Location: ../views/Login.php");
            exit();
        }
    }

    // SE NÃO FOR FUNCIONÁRIO, VERIFICA COMO CLIENTE COMUM (seu código original)
    $sql = "SELECT 
                cliente.id_cliente,
                cliente.nome,
                cliente.email,
                cliente.datNasc,
                cliente.telefone,
                senha.senha AS senha_hash
            FROM cliente
            INNER JOIN senha ON cliente.id_cliente = senha.id_cliente
            WHERE cliente.email = '$email'";

    $result = $conn->query($sql);

    // Condição para pesquisar se realmente possui o dado
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($senhaDigitada, $user['senha_hash'])) {

            $_SESSION['id_cliente'] = $user['id_cliente'];
            $_SESSION['nome'] = $user['nome'];

            // Mensagem de sucesso
            $_SESSION['toast'] = [
                'message' => 'Login realizado com sucesso! Bem-vindo, ' . htmlspecialchars($user['nome']) . '! 👋',
                'type' => 'success'
            ];

            header("Location: ../views/Index.php");
            exit();

        } else {
            // Senha incorreta
            $_SESSION['toast'] = [
                'message' => 'Senha incorreta. Tente novamente! 🔒',
                'type' => 'error'
            ];
            header("Location: ../views/Login.php");
            exit();
        }
    } else {
        // Email não encontrado (nem como funcionário, nem como cliente)
        $_SESSION['toast'] = [
            'message' => 'Email não encontrado. Verifique ou cadastre-se! ✉️',
            'type' => 'error'
        ];
        header("Location: ../views/Login.php");
        exit();
    }

} else {
    // Campos não preenchidos
    $_SESSION['toast'] = [
        'message' => 'Por favor, preencha todos os campos! 📝',
        'type' => 'error'
    ];
    header("Location: ../views/Login.php");
    exit();
}
?>