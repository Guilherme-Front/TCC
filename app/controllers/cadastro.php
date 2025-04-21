<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["Nome"];
    $email = $_POST["Email"];
    $telefone = $_POST["Telefone"];
    $data = $_POST["Data"];

    $dataFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $data)));

    // Insere o cliente no banco
    $sqlCliente = "INSERT INTO cliente(nome, email, datNasc, telefone) 
                   VALUES ('$nome', '$email', '$dataFormatada', '$telefone')";
    $resultadoCliente = mysqli_query($conn, $sqlCliente);

    if ($resultadoCliente) {
        $_SESSION['id_cliente'] = mysqli_insert_id($conn); // Salva o ID do cliente
        $_SESSION['cadastro_concluido'] = true; // Marca o cadastro como concluído
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        header("Location: ../php/senha.php"); // Redireciona para a página de criação de senha
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar cliente: " . mysqli_error($conn);
        $_SESSION['cadastro_concluido'] = false; // Marca que o cadastro falhou
        header("Location: ../pages/Login.html"); // Redireciona para a página de cadastro
        exit();
    }

} else {
    header("Location: ../views/Login.html");
    exit();
}
?>
