<?php
session_start();
session_destroy();
header("Location: ../controllers/index.php"); // ou o caminho da sua home
exit();
?>