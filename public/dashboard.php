<?php
// public/dashboard.php
session_start();

if (!isset($_SESSION['user_email'])) {
    echo "Acesso negado.";
    exit;
}

echo "<h1>Bem-vindo, " . htmlspecialchars($_SESSION['user_name']) . "!</h1>";
echo "<p>Email: " . htmlspecialchars($_SESSION['user_email']) . "</p>";