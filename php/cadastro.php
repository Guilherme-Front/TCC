<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["Nome"];
    $email = $_POST["Email"];
    $telefone = $_POST["Telefone"];
    $data = $_POST["Data"];

    // Primeiro insert
    $sqlCliente = "INSERT INTO cliente(nome, email, datNasc) VALUES ('$nome', '$email', '$data')";
    $resultadoCliente = mysqli_query($conn, $sqlCliente);

    // Segundo insert
    $sqlTelefone = "INSERT INTO telefone(numero) VALUES ('$telefone')";
    $resultadoTelefone = mysqli_query($conn, $sqlTelefone);

    if ($resultadoCliente && $resultadoTelefone) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($conn);
    }

    $conn->close();
    header("Location: ../pages/Senha.html");
    exit();

} else {
    header("Location: ../pages/Index.html");
    exit(); // importante para parar o script
}
?>
