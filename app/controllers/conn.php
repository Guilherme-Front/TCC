<?php
date_default_timezone_set('America/Sao_Paulo');

// Configurações de conexão
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pet_insight';

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Configurar charset para UTF-8 (suporte completo a caracteres especiais)
if (!$conn->set_charset("utf8mb4")) {
    die("Erro ao configurar charset utf8mb4: " . $conn->error);
}

// Verificar versão do MySQL/MariaDB para compatibilidade
if ($conn->server_version < 50503) {
    die("Requer MySQL 5.5.3 ou superior para suporte a utf8mb4");
}

// Configurações adicionais para garantir compatibilidade
$conn->query("SET NAMES 'utf8mb4'");
$conn->query("SET CHARACTER SET 'utf8mb4'");
$conn->query("SET COLLATION_CONNECTION = 'utf8mb4_unicode_ci'");
?>