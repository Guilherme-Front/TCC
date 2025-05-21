<?php
session_start();
include_once "../controllers/conn.php";

// Verifica se foi inserido algo nos inputs e se o botão foi clicado
if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

    // Variável para receber dados do formulário
    $email = $conn->real_escape_string($_POST['email']);
    $senhaDigitada = $_POST['senha'];

    // Select na tabela cliente e senha para comparar dados
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
        // Email não encontrado
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