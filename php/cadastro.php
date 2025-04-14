<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["Nome"];
    $email = $_POST["Email"];
    $telefone = $_POST["Telefone"];
    $data = $_POST["Data"];

    // Primeiro insert
    $sqlCliente = "INSERT INTO cliente(nome, email, telefone, data_nasc) VALUES ('$nome', '$email', '$telefone', '$data')";
    $resultadoCliente = mysqli_query($conn, $sqlCliente);

    // Segundo insert
    $sqlTelefone = "INSERT INTO telefone(numero) VALUES ('$telefone')";
    $resultadoTelefone = mysqli_query($conn, $sqlTelefone);

    if ($resultadoCliente && $resultadoTelefone) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        header("Location: ../pages/Senha.html"); // Agora redireciona aqui no sucesso
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($conn);
        header("Location: ../pages/Index.html"); // Redireciona aqui no erro de inserção
    }

    $conn->close();
    exit();

} else {
    header("Location: ../pages/Index.html"); // Redireciona aqui se não for POST
    exit();
}
