<?php
session_start();
require_once '../controllers/conn.php'; // Ajuste conforme seu caminho

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id_produto']) || !isset($_POST['quantidade'])) {
        echo json_encode(['erro' => 'Parâmetros inválidos']);
        exit;
    }

    $id_produto = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    // Verificar se o produto existe e tem estoque suficiente
    $sql = "SELECT quantidade FROM produto WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['erro' => 'Produto não encontrado']);
        exit;
    }

    $produto = $result->fetch_assoc();
    $estoque = (int)$produto['quantidade'];

    if ($estoque >= $quantidade) {
        echo json_encode([
            'disponivel' => true,
            'estoque' => $estoque
        ]);
    } else {
        echo json_encode([
            'disponivel' => false,
            'estoque' => $estoque
        ]);
    }
} else {
    echo json_encode(['erro' => 'Método não permitido']);
}

$conn->close();
?>