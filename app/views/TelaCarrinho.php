<?php

session_start();


// Verifica se o usuário está autenticado
if (!isset($_SESSION['id_cliente'])) {

    // Usuário não está autenticado, redireciona para o login
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

                <p class="total"><strong>Total:</strong> R$ 199,99</p>
            </div>

            <div class="cart-actions">
                <a href="../views/TelaProdutos.php"><button aria-label="botao" class="fechar-tela">Escolher mais
                        produtos</button></a>

                <button type="button" class="finalizar-pedido" id="finalizar-compra">
                    <i class="fas fa-credit-card"></i> Finalizar Compra
                </button>
            </div>

        </section>
    </main>



    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const publicKey = 'APP_USR-a5a070ce-204d-4728-a137-917c5416df17';
            const mp = new MercadoPago(publicKey, { locale: 'pt-BR' });

            document.getElementById('finalizar-compra').addEventListener('click', async function () {
                const button = this;
                button.disabled = true;
                button.textContent = 'Processando...';

                try {
                    // 1. Verificar se a resposta é JSON válido
                    const response = await fetch('/PagamentoController/criarPreferencia', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json' // Garantir que queremos JSON
                        },
                        body: JSON.stringify({
                            // Seus dados do pedido aqui
                        })
                    });

                    // 2. Verificar se a resposta é JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const textResponse = await response.text();
                        throw new Error(`Resposta inesperada: ${textResponse.substring(0, 100)}...`);
                    }

                    // 3. Processar a resposta JSON
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Erro ao criar pagamento');
                    }

                    // 4. Iniciar checkout
                    mp.checkout({
                        preference: { id: data.id },
                        render: { container: '#finalizar-compra', label: 'Finalizar Compra' },
                        autoOpen: true
                    });

                } catch (error) {
                    console.error('Erro no checkout:', error);
                    alert(`Erro: ${error.message}`);
                    button.disabled = false;
                    button.textContent = 'Finalizar Compra';
                }
            });
        });

        // Variáveis globais
        const idCliente = <?= json_encode($_SESSION['id_cliente'] ?? null) ?>;
        const carrinhoKey = `carrinho_${idCliente}`;
        const carrinhoVazioKey = `carrinhoVazio_${idCliente}`;

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

        // Função para verificar se o carrinho está vazio
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
                localStorage.setItem(carrinhoVazioKey, 'true');
            } else {
                txtDescricao.style.display = 'flex';
                mensagemVazio.style.display = 'none';
                if (botaoLimpar) botaoLimpar.style.display = 'inline-block';
                if (total) total.style.display = 'block';
                if (botaoFinalizar) botaoFinalizar.style.display = 'inline-block';
                localStorage.removeItem(carrinhoVazioKey);
            }
        }

        // Função para carregar os itens do carrinho
        async function carregarCarrinho() {
            const container = document.querySelector('.pedido-container');
            const mensagemVazio = document.getElementById('mensagem-vazio');
            const txtDescricao = document.querySelector('.todos');

            // Debug: Verifica dados iniciais
            console.log('ID Cliente:', idCliente);
            console.log('Chave do carrinho:', carrinhoKey);

            let carrinho = [];
            try {
                const carrinhoData = localStorage.getItem(carrinhoKey);
                console.log('Dados brutos do carrinho:', carrinhoData); // Debug

                carrinho = carrinhoData ? JSON.parse(carrinhoData) : [];
                console.log('Carrinho parseado:', carrinho); // Debug

                if (!Array.isArray(carrinho)) {
                    console.error('Dados do carrinho não são um array, resetando...');
                    carrinho = [];
                    localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
                }
            } catch (e) {
                console.error('Erro ao parsear carrinho:', e);
                carrinho = [];
                localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
            }

            if (carrinho.length === 0) {
                container.innerHTML = '';
                verificarCarrinhoVazio();
                return;
            }

            // Limpa o container antes de adicionar os itens
            container.innerHTML = '';

            // Flag para controlar se algum produto foi adicionado com sucesso
            let algumProdutoAdicionado = false;

            // Processa cada produto do carrinho
            for (const produto of carrinho) {
                try {
                    // Verifica se o produto tem estrutura mínima válida
                    if (!produto.id || !produto.nome || !produto.preco || !produto.quantidade) {
                        console.error('Produto inválido no carrinho:', produto);
                        continue;
                    }

                    // Tenta verificar o estoque (mas não bloqueia a exibição se falhar)
                    let emEstoque = true;
                    let statusEstoque = 'Em estoque';

                    try {
                        const response = await fetch('../controllers/verificaEstoque.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `id_produto=${produto.id}&quantidade=${produto.quantidade}`
                        });

                        if (response.ok) {
                            const data = await response.json();
                            emEstoque = data.disponivel || false;
                            const estoqueAtual = data.estoque || 0;
                            statusEstoque = emEstoque ? 'Em estoque' : `Estoque insuficiente (${estoqueAtual} disponíveis)`;
                        } else {
                            console.error('Erro na resposta da API de estoque:', response.status);
                        }
                    } catch (err) {
                        console.error('Erro ao verificar estoque, exibindo produto mesmo assim:', err);
                        statusEstoque = 'Estoque não verificado';
                    }

                    // Calcula o subtotal
                    const subtotal = produto.preco * produto.quantidade;

                    // Cria o HTML do produto
                    const pedidoHTML = `
                    <div class="pedido" data-produto-id="${produto.id}">
                    <div class="img-produto">
                    <img src="${produto.imagem || '../../public/img/sem-imagem.jpg'}" alt="${produto.nome}">
                    </div>
                    
                    <div class="descricao-total">
                    <div class="descricao">
                    <h3>${produto.nome}</h3>
                    <p class="${emEstoque ? 'em-estoque' : 'sem-estoque'}">${statusEstoque}</p>
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
                        <button class="excluir" type="button" onclick="excluirPedido(this)" 
                        data-produto-id="${produto.id}">
                        <img src="../../public/img/x-button.png" alt="excluir">
                        </button>
                        </div>
                        </div>
                        `;

                    container.insertAdjacentHTML('beforeend', pedidoHTML);
                    algumProdutoAdicionado = true;

                } catch (err) {
                    console.error('Erro ao processar produto:', produto, err);
                }
            }

            // Atualiza totais e verifica se o carrinho está vazio
            atualizarTotalCarrinho();
            verificarCarrinhoVazio();

            // Se nenhum produto foi adicionado (todos inválidos), mostra carrinho vazio
            if (!algumProdutoAdicionado) {
                container.innerHTML = '';
                localStorage.setItem(carrinhoKey, JSON.stringify([]));
                verificarCarrinhoVazio();
            }
        }

        // Função para alterar a quantidade de um produto
        async function alterarQuantidade(botao, valor) {
            const pedido = botao.closest('.pedido');
            const input = pedido.querySelector('.quantidade-produto');
            const produtoId = parseInt(input.getAttribute('data-produto-id'));
            const quantidadeAtual = parseInt(input.value);
            const novaQuantidade = quantidadeAtual + valor;

            if (novaQuantidade < 1) {
                return;
            }

            try {
                // Verificar estoque antes de atualizar
                const response = await fetch('../controllers/verificaEstoque.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_produto=${produtoId}&quantidade=${novaQuantidade}`
                });

                const data = await response.json();

                if (data.erro) {
                    error(data.erro, "linear-gradient(to right, #cd1809, #a01006)");
                    return;
                }

                if (!data.disponivel) {
                    error(`Quantidade indisponível em estoque. Máximo: ${data.estoque}`,
                        "linear-gradient(to right, #cd1809, #a01006)");
                    return;
                }

                // Atualizar a quantidade
                input.value = novaQuantidade;

                // Atualizar no localStorage
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

            // Filtrar para remover o produto
            carrinho = carrinho.filter(produto => produto.id !== produtoId);

            // Atualizar localStorage
            localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));

            // Remover visualmente
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
                // Verificar estoque para todos os itens
                for (const item of carrinho) {
                    const response = await fetch('../controllers/verificaEstoque.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_produto=${item.id}&quantidade=${item.quantidade}`
                    });

                    const data = await response.json();

                    if (!data.disponivel) {
                        error(`O produto "${item.nome}" não tem estoque suficiente. Máximo disponível: ${data.estoque}`,
                            "linear-gradient(to right, #cd1809, #a01006)");
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

        // Inicialização quando o DOM estiver carregado
        document.addEventListener('DOMContentLoaded', () => {
            // Carregar carrinho
            carregarCarrinho();

            // Evento para limpar carrinho
            document.querySelector('.button-limpar')?.addEventListener('click', limparCarrinho);

            // Evento para finalizar compra
            document.querySelector('.finalizar-pedido')?.addEventListener('click', async function () {
                const estoqueOk = await verificarEstoqueAntesFinalizar();

                if (estoqueOk) {
                    window.location.href = '../views/TelaCheckout.php';
                }
            });
        });

        function adicionarAoCarrinho(produto) {
            let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            // Verifica se o produto já está no carrinho
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