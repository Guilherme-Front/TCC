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
    $stmt = $conn->prepare("SELECT id_produto, nome_produto, valor, quantidade FROM produto WHERE id_produto = ?");
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

    // 2. Buscar imagem do produto
    $stmt_img = $conn->prepare("SELECT nome_imagem FROM imagem_produto WHERE id_produto = ? LIMIT 1");
    $stmt_img->bind_param("i", $id_produto);
    $stmt_img->execute();
    $imagem = $stmt_img->get_result()->fetch_assoc();

    // 3. Definir caminho da imagem (verifique se o caminho está correto conforme sua estrutura)
    // Altere para caminho absoluto ou URL completa
    $base_url = 'http://' . $_SERVER['HTTP_HOST'];

    $imagem_path = $imagem
        ? $base_url . '/TCC/uploads/imgProdutos/' . $id_produto . '/' . basename($imagem['nome_imagem'])
        : $base_url . '/TCC/img/sem-imagem.jpg';

    // 4. Retornar os dados do produto
    echo json_encode([
        'success' => true,
        'message' => 'Produto adicionado ao carrinho!',
        'produto' => [
            'id' => $produto['id_produto'],
            'nome' => $produto['nome_produto'],
            'preco' => (float)$produto['valor'],
            'quantidade' => $quantidade,
            'imagem' => $imagem_path
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar sua solicitação'
    ]);
}
