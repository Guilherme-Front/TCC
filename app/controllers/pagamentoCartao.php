<?php
require __DIR__ . '/../config/mercado_pago_config.php';

$token = $_POST['token'] ?? '';
$valorTotal = floatval($_POST['total'] ?? 0);
$parcelas = intval($_POST['parcelas'] ?? 1);
$email = $_POST['email'] ?? '';

if (!$token || $valorTotal <= 0 || !$email) {
    echo json_encode(['erro' => 'Dados inválidos']);
    exit;
}

$payment = new MercadoPago\Payment();
$payment->transaction_amount = $valorTotal;
$payment->token = $token;
$payment->installments = $parcelas;
$payment->payment_method_id = "visa"; // Ou dinâmico dependendo do cartão
$payment->payer = array(
    "email" => $email
);

$payment->save();

if ($payment->status == "approved") {
    echo json_encode(['status' => 'sucesso', 'id_pagamento' => $payment->id]);
} else {
    echo json_encode(['erro' => 'Falha no pagamento', 'status' => $payment->status]);
}
