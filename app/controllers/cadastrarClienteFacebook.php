<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Ajuste para o domínio certo em produção
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui a conexão com o banco
require_once '../controllers/conn.php'; // <- troque se o nome do seu arquivo for diferente

// Recebe os dados JSON
$data = json_decode(file_get_contents("php://input"), true);
$nome = $data['nome'] ?? null;
$email = $data['email'] ?? null;
$datNasc = $data['datNasc'] ?? null; // Formato: YYYY-MM-DD

if (!$nome || !$email) {
    http_response_code(400);
    echo json_encode(['erro' => 'Nome e e-mail são obrigatórios.']);
    exit;
}

try {
    // Verifica se o e-mail já existe
    $sql = "SELECT * FROM cliente WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        echo json_encode([
            'mensagem' => 'Cliente já cadastrado',
            'cliente' => $cliente
        ]);
        exit;
    }

    // Insere novo cliente
    $sql = "INSERT INTO cliente (nome, email, datNasc, telefone) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $datNasc, null]); // telefone fica nulo por enquanto

    echo json_encode([
        'mensagem' => 'Cliente cadastrado com sucesso',
        'id_cliente' => $pdo->lastInsertId()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
