function atualizarSubtotal(pedido) {
    let precoUnitarioTexto = pedido.querySelector('.dados p:nth-child(1)').innerText;
    let precoUnitario = parseFloat(precoUnitarioTexto.replace('R$ ', '').replace(',', '.'));

    let quantidade = parseInt(pedido.querySelector('.quantidade-produto').value);
    let novoSubtotal = precoUnitario * quantidade;

    pedido.querySelector('.dados p:nth-child(2)').innerText = `R$ ${novoSubtotal.toFixed(2).replace('.', ',')}`;
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

// Função para carregar os itens do carrinho quando a página é aberta
        function carregarCarrinho() {
            const container = document.querySelector('.pedido-container');
            const carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            if (carrinho.length === 0) {
                verificarCarrinhoVazio();
                return;
            }

            container.innerHTML = ''; // Limpa o container antes de adicionar os itens

            carrinho.forEach(produto => {
                const subtotal = produto.preco * produto.quantidade;

                const pedidoHTML = `
            <div class="pedido">
                <div class="img-produto">
                    <img src="${produto.imagem}" alt="${produto.nome}">
                </div>

                <div class="descricao-total">
                    <div class="descricao">
                        <h3>${produto.nome}</h3>
                        <p>Em estoque</p>
                    </div>

                    <div class="informacoes">
                        <div class="quantidade">
                            <button class="button-add" onclick="alterarQuantidade(this, -1)">∨</button>
                            <input aria-label="inp" class="input-add quantidade-produto" type="text" 
                                   value="${produto.quantidade}" readonly data-produto-id="${produto.id}">
                            <button class="button-add2" onclick="alterarQuantidade(this, 1)">∧</button>
                        </div>

                        <div class="dados">
                            <p>R$ ${produto.preco.toFixed(2).replace('.', ',')}</p>
                            <p>R$ ${subtotal.toFixed(2).replace('.', ',')}</p>
                        </div>
                    </div>
                </div>

                <div class="button-excluir">
                    <button class="excluir" type="button" onclick="excluirPedido(this)" 
                            data-produto-id="${produto.id}">
                        <img src="../../public/img/x-button.png" alt="excluir">
                    </button>
                </div>
            </div>
        `;

                container.insertAdjacentHTML('beforeend', pedidoHTML);
            });

            atualizarTotalCarrinho();
            verificarCarrinhoVazio();
        }

        // Modificar a função excluirPedido para remover do localStorage
        function excluirPedido(botao) {
            const produtoId = parseInt(botao.getAttribute('data-produto-id'));
            let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            // Filtrar para remover o produto
            carrinho = carrinho.filter(produto => produto.id !== produtoId);

            // Atualizar localStorage
            localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));

            // Remover visualmente
            let pedido = botao.closest('.pedido');
            pedido.remove();

            atualizarTotalCarrinho();
            verificarCarrinhoVazio();

            if (carrinho.length === 0) {
                localStorage.setItem(carrinhoVazioKey, 'true');
            }
        }

        // Modificar a função alterarQuantidade para atualizar o localStorage
        function alterarQuantidade(botao, valor) {
            let pedido = botao.closest('.pedido');
            let input = pedido.querySelector('.quantidade-produto');
            let produtoId = parseInt(input.getAttribute('data-produto-id'));
            let quantidade = parseInt(input.value) + valor;

            if (quantidade >= 1) {
                input.value = quantidade;

                // Atualizar no localStorage
                let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];
                const produtoIndex = carrinho.findIndex(p => p.id === produtoId);

                if (produtoIndex !== -1) {
                    carrinho[produtoIndex].quantidade = quantidade;
                    localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
                }

                atualizarSubtotal(pedido);
                atualizarTotalCarrinho();
            }
        }

        // Modificar o DOMContentLoaded para carregar o carrinho
        document.addEventListener('DOMContentLoaded', () => {
            carregarCarrinho();

            document.querySelector('.button-limpar')?.addEventListener('click', limparCarrinho);

            document.querySelector('.pedido-container')?.addEventListener('click', (event) => {
                const botao = event.target.closest('.excluir');
                if (botao) {
                    excluirPedido(botao);
                }
            });

            // Adicionar evento ao botão de finalizar compra
            document.querySelector('.finalizar-pedido')?.addEventListener('click', function() {
                // Verificar se o carrinho está vazio
                const carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];
                if (carrinho.length === 0) {
                    alert('Seu carrinho está vazio!');
                    return;
                }

                // Redirecionar para a página de checkout
                window.location.href = '../views/TelaCheckout.php';
            });
        });

        // Modificar a função limparCarrinho para limpar o localStorage
        function limparCarrinho() {
            localStorage.removeItem(carrinhoKey);
            localStorage.setItem(carrinhoVazioKey, 'true');

            const container = document.querySelector('.pedido-container');
            container.innerHTML = '';
            atualizarTotalCarrinho();
            verificarCarrinhoVazio();
        }