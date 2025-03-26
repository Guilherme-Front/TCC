<?php
include "conn.php";
/*
nome completo
email
telefone
data_nasc
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$senha = $_POST["senha"];
$vSenha = $_POST["vSenha"];


echo "Senha: " . ($senha) . "<br>";
echo "Confirme sua senha: " . ($vSenha) . "<br>";


} else {
    header("location: index.html");
}