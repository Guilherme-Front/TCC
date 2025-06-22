<?php
require_once __DIR__.'/../../../app/config/database.php';
require_once __DIR__.'/../../../app/models/pedido.php'; 

header('Content-Type: application/json');
session_start();

// 1. Verificação do Método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método não permitido',
        'message' => 'Esta rota só aceita requisições POST'
    ]);
    exit;
}

// 2. Autenticação do Usuário
if (!isset($_SESSION['id_cliente'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Não autorizado',
        'message' => 'Você precisa estar logado para criar um pedido'
    ]);
    exit;
}

// 3. Obter e validar dados da requisição
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'JSON inválido',
        'message' => 'O corpo da requisição contém JSON malformado'
    ]);
    exit;
}

// 4. Validação dos campos obrigatórios
$requiredFields = ['itens', 'cliente_id'];
foreach ($requiredFields as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Dados incompletos',
            'message' => "O campo '$field' é obrigatório"
        ]);
        exit;
    }
}

// 5. Verificar se o cliente_id da sessão bate com o da requisição
if ($input['cliente_id'] !== $_SESSION['id_cliente']) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'error' => 'Acesso proibido',
        'message' => 'Você só pode criar pedidos para sua própria conta'
    ]);
    exit;
}

try {
    // 6. Conectar ao banco de dados
    $pdo = Database::connect();
    
    // 7. Iniciar transação
    $pdo->beginTransaction();

    // 8. Criar o pedido no banco de dados
    $pedidoModel = new Pedido($pdo);
    $pedidoId = $pedidoModel->criarPedido([
        'cliente_id' => $input['cliente_id'],
        'itens' => $input['itens'],
        'status' => 'pendente',
        'data_pedido' => date('Y-m-d H:i:s')
    ]);

    // 9. Registrar itens do pedido
    foreach ($input['itens'] as $item) {
        if (!isset($item['id_produto'], $item['quantidade'], $item['preco_unitario'])) {
            throw new Exception('Dados do item incompletos');
        }

        $pedidoModel->adicionarItem($pedidoId, [
            'id_produto' => $item['id_produto'],
            'quantidade' => $item['quantidade'],
            'preco_unitario' => $item['preco_unitario'],
            'subtotal' => $item['quantidade'] * $item['preco_unitario']
        ]);

        // Atualizar estoque (opcional)
        // $pedidoModel->atualizarEstoque($item['id_produto'], -$item['quantidade']);
    }

    // 10. Commit da transação
    $pdo->commit();

    // 11. Resposta de sucesso
    echo json_encode([
        'success' => true,
        'pedido_id' => $pedidoId,
        'message' => 'Pedido criado com sucesso',
        'data' => [
            'cliente_id' => $input['cliente_id'],
            'total_itens' => count($input['itens']),
            'status' => 'pendente'
        ]
    ]);

} catch (PDOException $e) {
    // 12. Rollback em caso de erro no banco
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    error_log('Erro no banco de dados: ');
};