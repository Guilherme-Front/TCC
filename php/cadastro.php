<?php
include "conn.php";
/*
nome completo
email
telefone
data_nasc
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$nome = $_POST["Nome"];
$email = $_POST["Email"];
$telefone = $_POST["Telefone"];
$data = $_POST["Data"];

echo "Nome Completo: " . htmlspecialchars($nome) . "<br>";
echo "E-mail: " . htmlspecialchars($email) . "<br>";
echo "Telefone: " . htmlspecialchars($telefone) . "<br>";
echo "Data de Nascimento: " . htmlspecialchars($data) . "<br>";

} else {
    header("location: ../pages/senha.html");
}
?>