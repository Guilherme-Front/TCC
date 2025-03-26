<?php
date_default_timezone_set('America/Sao_Paulo');
$conn= new mysqli('localhost','root','','pet_insight');


$conn ->set_charset("utf8");


if ($conn->connect_error) {
    die("Falha na conexão: " . $$conn->connect_error);
}




?>