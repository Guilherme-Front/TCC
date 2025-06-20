// Configuração do Mercado Pago
const publicKey = 'APP_USR-a5a070ce-204d-4728-a137-917c5416df17';

document.addEventListener('DOMContentLoaded', () => {
    const mp = new MercadoPago(publicKey, {
        locale: 'pt-BR'
    });

    const checkoutButton = document.getElementById('checkout-button');
    
    if (checkoutButton) {
        checkoutButton.addEventListener('click', async function() {
            this.disabled = true;
            this.textContent = 'Processando...';
            
            try {
                const response = await fetch('/PagamentoController/criarPreferencia', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        produto: 'Nome do Produto',
                        quantidade: 1,
                        valor: 100.00
                    })
                });

                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Erro ao criar pagamento');
                }

                mp.checkout({
                    preference: {
                        id: data.id
                    },
                    render: {
                        container: '#checkout-button',
                        label: 'Finalizar Pagamento'
                    },
                    autoOpen: true
                });

            } catch (error) {
                console.error('Erro no checkout:', error);
                alert('Erro: ' + error.message);
                checkoutButton.disabled = false;
                checkoutButton.textContent = 'Pagar com Mercado Pago';
            }
        });
    }
});