<?php
include 'conn.php';

$senha = $_POST['senha'];
$confirmar = $_POST['confirmar_senha'];

if ($senha !== $confirmar) {
    die('Senhas não coincidem');
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO senha (senha) VALUES (?)");
$stmt->bind_param("s", $hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Senha cadastrada com sucesso.";
} else {
    echo "Erro ao cadastrar senha.";
}

$stmt->close();
$conn->close();
?>