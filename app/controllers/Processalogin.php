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
        
            header("Location: ../views/index.php");

        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado.";
    }

} else {
    echo "Preencha todos os campos.";
}
