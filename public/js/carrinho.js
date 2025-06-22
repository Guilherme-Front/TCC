import config from './config.js';

document.addEventListener('DOMContentLoaded', () => {
    // Carrega imagens corretamente
    document.querySelectorAll('.produto-img').forEach(img => {
        img.src = `${config.IMG_BASE}/${img.dataset.cat}/${img.dataset.file}`;
    });

    // Botão finalizar
    document.getElementById('btn-finalizar').addEventListener('click', async () => {
        try {
            const response = await fetch(`${config.API_URL}/pedidos/criar`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(getCarrinhoData())
            });
            
            // Processa resposta...
        } catch (error) {
            console.error('Erro:', error);
        }
    });
});