<?php
require '../config/db.php'; // adapte conforme seu caminho ao banco

if (isset($_POST['id_produto']) && isset($_POST['quantidade'])) {
    $id = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE id_produto = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        if ($produto['quantidade'] >= $quantidade) {
            echo json_encode(['disponivel' => true]);
        } else {
            echo json_encode(['disponivel' => false, 'estoque' => $produto['quantidade']]);
        }
    } else {
        echo json_encode(['erro' => 'Produto não encontrado']);
    }
} else {
    echo json_encode(['erro' => 'Parâmetros inválidos']);
}
