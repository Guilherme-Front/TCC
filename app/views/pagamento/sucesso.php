<?php
$pagamento = $pagamento ?? null;
$pedido = $pedido ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Aprovado</title>
    <link rel="stylesheet" href="/public/css/pagamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="payment-container">
        <div class="payment-status success">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Pagamento Aprovado!</h1>
            
            <?php if ($pagamento && $pedido): ?>
                <div class="payment-details">
                    <div class="detail-item">
                        <span class="label">Nº do Pedido:</span>
                        <span class="value">#<?= str_pad($pedido['id'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Valor Total:</span>
                        <span class="value">R$ <?= number_format($pagamento['valor'], 2, ',', '.') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Data:</span>
                        <span class="value"><?= date('d/m/Y H:i', strtotime($pagamento['data_criacao'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Status:</span>
                        <span class="value"><?= ucfirst($pagamento['status']) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="actions">
                <a href="/pedidos/detalhe/<?= $pedido['id'] ?? '' ?>" class="btn btn-primary">
                    <i class="fas fa-receipt"></i> Ver Detalhes do Pedido
                </a>
                <a href="/" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Voltar à Página Inicial
                </a>
            </div>
        </div>
    </div>
</body>
</html>