<?php
session_start();
require_once '../controllers/conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_cliente'])) {
    echo json_encode(['success' => false, 'message' => 'Por favor, faça login para continuar']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$id_produto = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
$quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

if (!$id_produto || !$quantidade) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

try {
    // 1. Verificar estoque
    $stmt = $conn->prepare("SELECT quantidade FROM produto WHERE id_produto = ?");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $produto = $stmt->get_result()->fetch_assoc();
    
    if (!$produto || $produto['quantidade'] < $quantidade) {
        echo json_encode([
            'success' => false, 
            'message' => 'Quantidade indisponível em estoque'
        ]);
        exit;
    }
    
    // 2. Adicionar ao carrinho (exemplo simplificado)
    $_SESSION['carrinho'][$id_produto] = [
        'quantidade' => $quantidade,
        'adicionado_em' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode([
        'success' => true,
        'message' => 'Produto adicionado ao carrinho!'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar sua solicitação'
    ]);
}