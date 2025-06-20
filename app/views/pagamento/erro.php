<?php
$erro = $erro ?? 'O pagamento não foi processado';
$codigoErro = $codigo_erro ?? null;
$pedidoId = $pedido_id ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro no Pagamento</title>
    <link rel="stylesheet" href="/public/css/pagamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="payment-container">
        <div class="payment-status error">
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h1>Pagamento Não Aprovado</h1>
            
            <div class="error-message">
                <p><?= htmlspecialchars($erro) ?></p>
                <?php if ($codigoErro): ?>
                    <p class="error-code">Código: <?= htmlspecialchars($codigoErro) ?></p>
                <?php endif; ?>
            </div>

            <div class="actions">
                <?php if ($pedidoId): ?>
                    <a href="/checkout?pedido_id=<?= $pedidoId ?>" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Tentar Novamente
                    </a>
                <?php endif; ?>
                
                <a href="/carrinho" class="btn btn-secondary">
                    <i class="fas fa-shopping-cart"></i> Voltar ao Carrinho
                </a>
            </div>
        </div>
    </div>
</body>
</html>