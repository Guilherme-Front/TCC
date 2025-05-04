<?php
// ./public/perfil.php
// “Front” que dispara sempre o Controller
require_once __DIR__ . '/../controllers/PerfilController.php';

$controller = new PerfilController();
$controller->exibirPerfil();