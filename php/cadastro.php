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

} else {
    header("location: ../pages/senha.html");
}
?>