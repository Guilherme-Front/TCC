<?php
// public/api/criar-pedido.php
require_once __DIR__.'/../../app/config/config.php';
require_once __DIR__.'/../../app/models/PedidoModel.php';

header('Content-Type: application/json');

try {
    // Autenticação (implemente conforme seu sistema)
    $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION'] ?? '');
    
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Dados inválidos");
    }

    // Validar dados
    if (empty($input['id_cliente']) || empty($input['itens'])) {
        throw new RuntimeException("Dados incompletos");
    }

   $db = new PDO('mysql:host=localhost;dbname=pet_insight', 'root', '');
$pedidoModel = new PedidoModel($db);
    // Criar pedido
    $pedidoId = $pedidoModel->criarPedido([
        'id_cliente' => (int)$input['id_cliente'],
        'itens' => array_map(function($item) {
            return [
                'id_produto' => (int)$item['id'],
                'quantidade' => (int)$item['quantidade'],
                'preco' => (float)$item['preco']
            ];
        }, $input['itens'])
    ]);

    echo json_encode([
        'success' => true,
        'pedido_id' => $pedidoId
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}