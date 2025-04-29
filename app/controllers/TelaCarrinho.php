<?php

session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id_cliente'])) {

    // Usuário não está autenticado, redireciona para o login
    header('Location: ../views/Login.html');
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
    <header>
        <a href="../controllers/Index.php">
            <img class="logo" src="../../public/img/Pet insight.png" alt="logo"></a>
        <a href="../controllers/telaPerfil.php">
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

            <div class="pedido-container">
                <div class="pedido">
                    <div class="img-produto">
                        <img src="../../public/img/casinha.png" alt="casinha">
                    </div>

                    <div class="descricao-total">
                        <div class="descricao">
                            <h3>Casinha de cachorro</h3>
                            <p>Em estoque</p>
                        </div>

                        <div class="informacoes">

                            <div class="quantidade">
                                <button class="button-add" onclick="alterarQuantidade(this, -1)">∨</button>
                                <input aria-label="inp" class="input-add quantidade-produto" type="text" value="1" readonly>
                                <button class="button-add2" onclick="alterarQuantidade(this, 1)">∧</button>
                            </div>

                            <div class="dados">
                                <p>R$ 79,99</p>
                                <p>R$ 79,99</p>
                            </div>
                        </div>
                    </div>

                    <div class="button-excluir">
                        <button class="excluir" type="button"><img src="../../public/img/x-button.png" alt="excluir"></button>
                    </div>
                </div>

                <div class="pedido">
                    <div class="img-produto">
                        <img src="../../public/img/casinha.png" alt="casinha">
                    </div>

                    <div class="descricao-total">
                        <div class="descricao">
                            <h3>Casinha de cachorro</h3>
                            <p>Em estoque</p>
                        </div>

                        <div class="informacoes">

                            <div class="quantidade">
                                <button class="button-add" onclick="alterarQuantidade(this, -1)">∨</button>
                                <input aria-label="inp" class="input-add quantidade-produto" type="text" value="1" readonly>
                                <button class="button-add2" onclick="alterarQuantidade(this, 1)">∧</button>
                            </div>

                            <div class="dados">
                                <p>R$ 79,99</p>
                                <p>R$ 79,99</p>
                            </div>
                        </div>
                    </div>

                    <div class="button-excluir">
                        <button class="excluir" type="button"><img src="../../public/img/x-button.png" alt="excluir"></button>
                    </div>
                </div>

                <div class="pedido">
                    <div class="img-produto">
                        <img src="../../public/img/casinha.png" alt="casinha">
                    </div>

                    <div class="descricao-total">
                        <div class="descricao">
                            <h3>Casinha de cachorro</h3>
                            <p>Em estoque</p>
                        </div>

                        <div class="informacoes">

                            <div class="quantidade">
                                <button class="button-add" onclick="alterarQuantidade(this, -1)">∨</button>
                                <input aria-label="inp" class="input-add quantidade-produto" type="text" value="1" readonly>
                                <button class="button-add2" onclick="alterarQuantidade(this, 1)">∧</button>
                            </div>

                            <div class="dados">
                                <p>R$ 79,99</p>
                                <p>R$ 79,99</p>
                            </div>
                        </div>
                    </div>

                    <div class="button-excluir">
                        <button class="excluir" type="button"><img src="../../public/img/x-button.png" alt="excluir"></button>
                    </div>
                </div>
            </div>

            <div class="cart-actions">
                <button class="button-limpar" type="button">Limpar carrinho</button>

                <p class="total"><strong>Total:</strong> R$ 199,99</p>
            </div>

            <div class="cart-actions">
                <a href="../controllers/TelaProdutos.php"><button aria-label="botao" class="fechar-tela">Escolher mais produtos</button></a>

                <button type="submit" class="finalizar-pedido">Finalizar compra</button>
            </div>

        </section>
    </main>

    <script src="../../public/js/Carrinho.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>