<?php

session_start();


if (!isset($_SESSION['id_cliente'])) {

    header('Location: ../views/Login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/carrinho.css?v=<?= time() ?>">

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
    <title>Tela de Carrinho | Pet Insight</title>

</head>

<body>

    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <header>
        <a href="../views/Index.php">
            <img class="logo" src="../../public/img/Pet insight.png" alt="logo"></a>
        <a href="../views/telaPerfil.php">
            <img class="user" src="../../public/img/user.png" alt="usuário">
        </a>
    </header>

    <main>
        <section>
            <div class="txt-carrinho">
                <h1>Carrinho de compras</h1>
                <img class="carrinhoC" src="../../public/img/carrinho.png" alt="">
            </div>

            <div class="todos">
                <div class="txt-descricao">
                    <p>Descrição</p>
                </div>

                <div class="txt-dados">
                    <p class="txt-quantidade">Quantidade</p>
                    <p>Preço unitário</p>
                    <p>Subtotal</p>
                </div>
            </div>

            <p id="mensagem-vazio" style="display: none; text-align: center; font-size: 18px; margin-top: 20px;">
                Carrinho vazio
            </p>

            <div class="pedido-container">
                <!--  -->
            </div>

            <div class="cart-actions">
                <button class="button-limpar" type="button" onclick="limparCarrinho()">Limpar carrinho</button>

                <p class="total"><strong>Total:</strong> R$ 00,00</p>
            </div>

            <div class="cart-actions">
                <a href="../views/TelaProdutos.php"><button aria-label="botao" class="fechar-tela">Escolher mais
                        produtos</button></a>

                <button id="finalizar-compra" onclick="comprarAgora()">
                    <span id="btn-text" class="finalizar-pedido">Finalizar Compra</span>
                    <span id="btn-loading" style="display:none;">
                        <i class="fa fa-spinner fa-spin"></i> Processando...
                    </span>
                </button>
            </div>

        </section>
    </main>

    <script>
        // Variáveis globais
        const idCliente = <?= json_encode($_SESSION['id_cliente'] ?? null) ?>;
        const carrinhoKey = `carrinho_${idCliente}`;
        const carrinhoVazioKey = `carrinhoVazio_${idCliente}`;

        document.addEventListener('DOMContentLoaded', () => {
            carregarCarrinho();

            document.querySelector('.button-limpar')?.addEventListener('click', limparCarrinho);

            document.querySelector('.finalizar-pedido')?.addEventListener('click', async () => {
                const estoqueOk = await verificarEstoqueAntesFinalizar();
                if (estoqueOk) {
                    window.location.href = '../views/TelaPagamento.php';
                }
            });
        });

        function comprarAgora() {
            window.location.href = '../views/telaPagamento.php'; // Ajuste o caminho conforme a estrutura do seu projeto
        }


        function verificarCarrinhoVazio() {
            const container = document.querySelector('.pedido-container');
            const mensagemVazio = document.getElementById('mensagem-vazio');
            const txtDescricao = document.querySelector('.todos');
            const botaoLimpar = document.querySelector('.button-limpar');
            const total = document.querySelector('.total');
            const botaoFinalizar = document.getElementById('finalizar-compra'); // Corrigido

            if (container.children.length === 0) {
                if (txtDescricao) txtDescricao.style.display = 'none';
                if (mensagemVazio) mensagemVazio.style.display = 'block';
                if (botaoLimpar) botaoLimpar.style.display = 'none';
                if (total) total.style.display = 'none';
                if (botaoFinalizar) botaoFinalizar.style.display = 'none'; // Esconde o botão inteiro
            } else {
                if (txtDescricao) txtDescricao.style.display = 'flex';
                if (mensagemVazio) mensagemVazio.style.display = 'none';
                if (botaoLimpar) botaoLimpar.style.display = 'inline-block';
                if (total) total.style.display = 'block';
                if (botaoFinalizar) botaoFinalizar.style.display = 'inline-block'; // Mostra o botão inteiro
            }
        }


        async function carregarCarrinho() {
            const container = document.querySelector('.pedido-container');
            container.innerHTML = ''; // limpa antes de inserir

            let carrinho = [];
            try {
                const carrinhoData = localStorage.getItem(carrinhoKey);
                carrinho = carrinhoData ? JSON.parse(carrinhoData) : [];
                if (!Array.isArray(carrinho)) {
                    carrinho = [];
                    localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
                }
            } catch {
                carrinho = [];
                localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
            }

            if (carrinho.length === 0) {
                verificarCarrinhoVazio();
                return;
            }

            // Primeiro renderiza todos os produtos com status genérico
            for (const produto of carrinho) {
                if (!produto.id || !produto.nome || !produto.preco || !produto.quantidade) {
                    continue;
                }
                if (produto.imagem && !produto.imagem.includes('/public/')) {
                    produto.imagem = produto.imagem.replace('/TCC/', '/TCC/public/');
                }
                const subtotal = produto.preco * produto.quantidade;

                const pedidoHTML = `
            <div class="pedido" data-produto-id="${produto.id}">
                <div class="img-produto">
                    <img src="${produto.imagem}" alt="${produto.nome}">
                </div>
                <div class="descricao-total">
                    <div class="descricao">
                        <h3>${produto.nome}</h3>
                        <p class="status-estoque">Verificando estoque...</p>
                    </div>
                    <div class="informacoes">
                        <div class="quantidade">
                            <button class="button-add" onclick="alterarQuantidade(this, -1)">−</button>
                            <input aria-label="inp" class="input-add quantidade-produto" type="text"
                                value="${produto.quantidade}" readonly data-produto-id="${produto.id}">
                            <button class="button-add2" onclick="alterarQuantidade(this, 1)">+</button>
                        </div>
                        <div class="dados">
                            <p>R$ ${produto.preco.toFixed(2).replace('.', ',')}</p>
                            <p>R$ ${subtotal.toFixed(2).replace('.', ',')}</p>
                        </div>
                    </div>
                </div>
                <div class="button-excluir">
                    <button class="excluir" type="button" onclick="excluirPedido(this)" data-produto-id="${produto.id}">
                        <img src="../../public/img/x-button.png" alt="excluir">
                    </button>
                </div>
            </div>`;

                container.insertAdjacentHTML('beforeend', pedidoHTML);
            }

            atualizarTotalCarrinho();
            verificarCarrinhoVazio();

            // Agora verifica o estoque para cada produto *em paralelo* e atualiza o DOM
            for (const produto of carrinho) {
                try {
                    const response = await fetch('../controllers/verificaEstoque.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_produto=${produto.id}&quantidade=${produto.quantidade}`
                    });

                    const data = await response.json();
                    const pedidoElem = container.querySelector(`.pedido[data-produto-id="${produto.id}"]`);
                    const statusElem = pedidoElem.querySelector('.status-estoque');

                    if (data.disponivel) {
                        statusElem.textContent = 'Em estoque';
                        statusElem.className = 'em-estoque';
                    } else {
                        statusElem.textContent = `Estoque insuficiente (${data.estoque} disponíveis)`;
                        statusElem.className = 'sem-estoque';
                    }
                } catch {
                    const pedidoElem = container.querySelector(`.pedido[data-produto-id="${produto.id}"]`);
                    const statusElem = pedidoElem.querySelector('.status-estoque');
                    statusElem.textContent = 'Estoque não verificado';
                    statusElem.className = '';
                }
            }
        }

        // Função para alterar a quantidade de um produto
        async function alterarQuantidade(botao, valor) {
            const pedido = botao.closest('.pedido');
            const input = pedido.querySelector('.quantidade-produto');
            const produtoId = parseInt(input.getAttribute('data-produto-id'));
            const quantidadeAtual = parseInt(input.value);
            const novaQuantidade = quantidadeAtual + valor;

            if (novaQuantidade < 1) return;

            try {
                const response = await fetch('../controllers/verificaEstoque.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id_produto=${produtoId}&quantidade=${novaQuantidade}`
                });

                const data = await response.json();

                if (data.erro) {
                    error(data.erro, "linear-gradient(to right, #cd1809, #a01006)");
                    return;
                }

                if (!data.disponivel) {
                    error(`Quantidade indisponível em estoque. Máximo: ${data.estoque}`, "linear-gradient(to right, #cd1809, #a01006)");
                    return;
                }

                input.value = novaQuantidade;

                const carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];
                const produtoIndex = carrinho.findIndex(p => p.id === produtoId);

                if (produtoIndex !== -1) {
                    carrinho[produtoIndex].quantidade = novaQuantidade;
                    localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
                }

                atualizarSubtotal(pedido);
                atualizarTotalCarrinho();

            } catch (err) {
                console.error('Erro ao verificar estoque:', err);
                error("Erro ao atualizar quantidade", "linear-gradient(to right, #cd1809, #a01006)");
            }
        }

        // Função para excluir um produto do carrinho
        function excluirPedido(botao) {
            const produtoId = parseInt(botao.getAttribute('data-produto-id'));
            let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            carrinho = carrinho.filter(produto => produto.id !== produtoId);

            localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));

            const pedido = botao.closest('.pedido');
            pedido.remove();

            atualizarTotalCarrinho();
            verificarCarrinhoVazio();

            if (carrinho.length === 0) {
                localStorage.setItem(carrinhoVazioKey, 'true');
            }
        }

        // Função para limpar todo o carrinho
        function limparCarrinho() {
            localStorage.removeItem(carrinhoKey);
            localStorage.setItem(carrinhoVazioKey, 'true');

            const container = document.querySelector('.pedido-container');
            container.innerHTML = '';
            atualizarTotalCarrinho();
            verificarCarrinhoVazio();
        }

        // Função para verificar estoque antes de finalizar a compra
        async function verificarEstoqueAntesFinalizar() {
            const carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            if (carrinho.length === 0) {
                error("Seu carrinho está vazio!", "linear-gradient(to right, #cd1809, #a01006)");
                return false;
            }

            try {
                for (const item of carrinho) {
                    const response = await fetch('../controllers/verificaEstoque.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_produto=${item.id}&quantidade=${item.quantidade}`
                    });

                    const data = await response.json();

                    if (!data.disponivel) {
                        error(`O produto "${item.nome}" não tem estoque suficiente. Máximo disponível: ${data.estoque}`, "linear-gradient(to right, #cd1809, #a01006)");
                        return false;
                    }
                }
                return true;
            } catch (err) {
                console.error('Erro ao verificar estoque:', err);
                error("Erro ao verificar disponibilidade dos produtos", "linear-gradient(to right, #cd1809, #a01006)");
                return false;
            }
        }

        // Função para exibir mensagens de erro
        function error(message, color) {
            Toastify({
                text: message,
                duration: 3500,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: color,
                },
            }).showToast();
        }

        // Função para atualizar o subtotal de um item
        function atualizarSubtotal(pedido) {
            let precoUnitarioTexto = pedido.querySelector('.dados p:nth-child(1)').innerText;
            let precoUnitario = parseFloat(precoUnitarioTexto.replace('R$ ', '').replace(',', '.'));

            let quantidade = parseInt(pedido.querySelector('.quantidade-produto').value);
            let novoSubtotal = precoUnitario * quantidade;

            pedido.querySelector('.dados p:nth-child(2)').innerText = `R$ ${novoSubtotal.toFixed(2).replace('.', ',')}`;
        }

        // Função para atualizar o total do carrinho
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

        // Função para adicionar ao carrinho (exemplo básico)
        function adicionarAoCarrinho(produto) {
            let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            const itemExistente = carrinho.find(item => item.id === produto.id);

            if (itemExistente) {
                itemExistente.quantidade += produto.quantidade || 1;
            } else {
                carrinho.push(produto);
            }

            localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
        }
    </script>

    <script src="../../public/js/tema.js"></script>
</body>

</html>