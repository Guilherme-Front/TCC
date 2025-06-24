<?php
require __DIR__ . '/../config/mercado_pago_config.php';

header('Content-Type: application/json');

$valor = floatval($_POST['total'] ?? 0);

if ($valor <= 0) {
    echo json_encode(['erro' => 'Valor total inválido.']);
    exit;
}

$payment = new MercadoPago\Payment();
$payment->transaction_amount = $valor;
$payment->description = "Pagamento via PIX - Pedido Site";
$payment->payment_method_id = "pix";
$payment->payer = ["email" => "cliente@email.com"]; 

$payment->save();

if ($payment->status === "pending") {
    echo json_encode([
        'status' => 'pendente',
        'qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
        'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
        'id_pagamento' => $payment->id
    ]);
} else {
    echo json_encode(['erro' => 'Falha ao criar pagamento PIX.']);
}
