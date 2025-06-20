<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pagamento</title>
    <link rel="stylesheet" href="/public/css/checkout.css">
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Finalize seu pagamento</h1>
            <p>Pedido #<?= htmlspecialchars($_GET['pedido_id'] ?? '') ?></p>
        </div>
        
        <div id="checkout-button" class="mp-button"></div>
        
        <div class="checkout-footer">
            <p>Pagamento seguro via Mercado Pago</p>
            <img src="/public/img/mercado-pago-security.png" alt="Segurança Mercado Pago">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mp = new MercadoPago('<?= include '../app/config/mercado_pago.php'['public_key'] ?>', {
                locale: 'pt-BR'
            });
            
            const preferenceId = '<?= htmlspecialchars($_GET['preference_id'] ?? '') ?>';
            
            if (!preferenceId) {
                alert('Erro: ID de preferência não encontrado');
                window.location.href = '/carrinho';
                return;
            }
            
            mp.checkout({
                preference: {
                    id: preferenceId
                },
                render: {
                    container: '#checkout-button',
                    label: 'Pagar com Mercado Pago'
                },
                autoOpen: true
            });
        });
    </script>
</body>
</html>