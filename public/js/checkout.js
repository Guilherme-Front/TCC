<script>
document.addEventListener('DOMContentLoaded', () => {
    const mp = new MercadoPago('<?= include '../app/config/mercado_pago.php'['public_key'] ?>', 
    {
        locale: 'pt-BR'
    });
    
    document.getElementById('checkout-button').addEventListener('click', async () => {
        try {
            const response = await fetch('/PagamentoController/criarPreferencia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    produto: 'Nome do Produto',
                    quantidade: 1,
                    valor: 100.00
                })
            });
            
            const { id } = await response.json();
            
            mp.checkout({
                preference: { id },
                render: { container: '#checkout-button' }
            });
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao processar pagamento');
        }
    });
});
</script>