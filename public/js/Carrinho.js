function alterarQuantidade(botao, valor) {
    let pedido = botao.closest('.pedido');
    let input = pedido.querySelector('.quantidade-produto');
    let quantidade = parseInt(input.value) + valor;
    if (quantidade >= 1) {
        input.value = quantidade;
        atualizarSubtotal(pedido); // Atualiza o subtotal do item
        atualizarTotalCarrinho(); // Atualiza o total geral
    }
}

function atualizarSubtotal(pedido) {
    let precoUnitarioTexto = pedido.querySelector('.dados p:nth-child(1)').innerText;
    let precoUnitario = parseFloat(precoUnitarioTexto.replace('R$ ', '').replace(',', '.'));

    let quantidade = parseInt(pedido.querySelector('.quantidade-produto').value);
    let novoSubtotal = precoUnitario * quantidade;

    pedido.querySelector('.dados p:nth-child(2)').innerText = `R$ ${novoSubtotal.toFixed(2).replace('.', ',')}`;
}

function excluirPedido(botao) {
    let pedido = botao.closest('.pedido');
    pedido.remove();
    atualizarTotalCarrinho();
    verificarCarrinhoVazio();
    salvarEstadoCarrinho();

    setTimeout(() => {
        verificarCarrinhoVazio();
        salvarEstadoCarrinho();
    }, 0);
}

function limparCarrinho() {
    const container = document.querySelector('.pedido-container');
    container.innerHTML = '';
    atualizarTotalCarrinho();
    verificarCarrinhoVazio();
    localStorage.setItem('carrinhoVazio', 'true');
}

function atualizarTotalCarrinho() {
    let total = 0;
    document.querySelectorAll('.pedido').forEach(pedido => {
        let subtotal = parseFloat(
            pedido.querySelector('.dados p:nth-child(2)')
                .innerText.replace('R$ ', '').replace(',', '.')
        );
        total += subtotal;
    });

    document.querySelector('.total').innerHTML = `<strong>Total:</strong> R$ ${total.toFixed(2).replace('.', ',')}`;
}

function verificarCarrinhoVazio() {
    const container = document.querySelector('.pedido-container');
    const mensagemVazio = document.getElementById('mensagem-vazio');
    const txtDescricao = document.querySelector('.todos');
    const botaoLimpar = document.querySelector('.button-limpar');
    const total = document.querySelector('.total');
    const botaoFinalizar = document.querySelector('.finalizar-pedido');

    if (container.children.length === 0) {
        txtDescricao.style.display = 'none';
        mensagemVazio.style.display = 'block';
        if (botaoLimpar) botaoLimpar.style.display = 'none';
        if (total) total.style.display = 'none';
        if (botaoFinalizar) botaoFinalizar.style.display = 'none';

    } else {
        txtDescricao.style.display = 'flex';
        mensagemVazio.style.display = 'none';
        if (botaoLimpar) botaoLimpar.style.display = 'inline-block';
        if (total) total.style.display = 'block';
        if (botaoFinalizar) botaoFinalizar.style.display = 'inline-block';
    }
}


function salvarEstadoCarrinho() {
    const container = document.querySelector('.pedido-container');
    if (container.children.length === 0) {
        localStorage.setItem('carrinhoVazio', 'true');
    } else {
        localStorage.removeItem('carrinhoVazio');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('carrinhoVazio') === 'true') {
        document.querySelector('.pedido-container').innerHTML = '';
        verificarCarrinhoVazio(); // MANTENHA DISTÂNCIA (ativar quando adicionar o produto ao carrinho de compras)
    }

    document.querySelector('.button-limpar')?.addEventListener('click', limparCarrinho);

    document.querySelector('.pedido-container')?.addEventListener('click', (event) => {
        const botao = event.target.closest('.excluir');
        if (botao) {
            excluirPedido(botao);
        }
    });

    atualizarTotalCarrinho();
    verificarCarrinhoVazio();
});
