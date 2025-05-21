<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'sessaoAtiva' => isset($_SESSION['cadastro_temp'])
]);
exit();
?>