<?php

require '../../vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-2868464185741237-062316-2874c46d11bdf215e6314aa63b0c920b-1173760382'); // Substitua pela sua chave secreta real

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Requisição inválida']);
    exit;
}

$token = $_POST['token'] ?? null;
$total = $_POST['total'] ?? null;
$installments = $_POST['installments'] ?? 1;
$payment_method_id = $_POST['payment_method_id'] ?? null;

if (!$token || !$total || !$payment_method_id) {
    echo json_encode(['erro' => 'Dados incompletos']);
    exit;
}

try {
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = (float)$total;
    $payment->token = $token;
    $payment->description = "Compra no Pet Insight";
    $payment->installments = (int)$installments;
    $payment->payment_method_id = $payment_method_id;
    $payment->payer = array(
        "email" => "comprador@email.com" // Substituir por e-mail real se desejar
    );

    $payment->save();

    echo json_encode([
        'status' => $payment->status,
        'status_detail' => $payment->status_detail,
        'id' => $payment->id
    ]);

} catch (Exception $e) {
    echo json_encode(['erro' => 'Erro ao processar pagamento: ' . $e->getMessage()]);
}
