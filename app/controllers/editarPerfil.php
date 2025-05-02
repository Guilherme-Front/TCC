<?php
session_start();
require_once '../conn.php';
require_once '../app/controllers/PerfilController.php';

if (!isset($_SESSION['id_cliente'])) {
    header('Location: Login.html');
    exit;
}

$id_cliente = $_SESSION['id_cliente'];

$controller = new PerfilController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $datNasc = $_POST['datNasc'] ?? '';

    $dataFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $datNasc)));

    $controller->atualizarPerfil($id_cliente, $nome, $email, $telefone, $dataFormatada);

    header('Location: perfil.php');
    exit;
}

$cliente = $controller->mostrarPerfil($id_cliente);

if (!$cliente) {
    echo "Cliente não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
</head>
<body>
    <h1>Editar Perfil</h1>

    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required><br><br>

        <label>Data de Nascimento:</label><br>
        <input type="text" name="datNasc" value="<?= htmlspecialchars(date('d/m/Y', strtotime($cliente['datNasc']))) ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="perfil.php">Cancelar</a>
</body>
</html>
