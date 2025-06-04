<?php
session_start();
require_once '../controllers/conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto'])) {
    $id_produto = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    // Atualizar o estoque (diminuir)
    $sql = "UPDATE produto SET quantidade = quantidade - ? WHERE id_produto = ? AND quantidade >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantidade, $id_produto, $quantidade);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Estoque insuficiente ou produto não encontrado']);
    }
} else {
    echo json_encode(['error' => 'Requisição inválida']);
}

$conn->close();
?>