<?php

session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntes Frequentes | Pet Insight</title>

    <link rel="stylesheet" href="../../public/css/stylefaq.css?v=<?= time() ?>">

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body class="faq-body">
    <header class="header">
        <div class="header_container">
            <div class="header-titulo">
                <a href="../controllers/Index.php"><img class="header-img" src="../../public/img/Pet insight.png"
                        alt="Imagem da Logo"></a>
            </div>

            <?php if (isset($_SESSION['id_cliente'])): ?>

                <div class="user-info">
                    <a class="header-link-none" href="../views/TelaPerfil.html">
                        <img class="user-img" src="../../public/img/user.png" alt="">
                    </a>

                    <form method="post" action="../controllers/logout.php" style="display:inline;">
                        <button type="submit" class="header-button-logout" aria-label="logout">Sair</button>
                    </form>
                </div>

            <?php else: ?>

                <div class="header-link-tema">
                    <a class="header-entrar" href="../views/Login.html">Entrar |</a>
                    <a class="header-cadastro" href="../views/Cadastro.html">Cadastro</a>
                </div>
            <?php endif; ?>

        </div>
    </header>

    <main class="faq_body">
        <section class="faq-flex">
            <div class="faq-perguntas">
                <div class="faq-h1">
                    <h1 class="faq-titulo">Perguntas Frequentes</h1>
                </div>

                <div class="faq-paragrafo">
                    <p class="faq-p">Bem-vindo a seção de perguntas frequentes onde você poderá encontrar explicações
                        claras e
                        rapidas sobre o nosso sistema.
                    </p>

                    <p class="faq-p">
                        Caso ainda possua perguntas sobre o nosso sistema após isso, contate a nossa equipe abaixo:
                    </p>
                </div>
            </div>

            <div class="faq-image">
                <img class="faq--cat" src="../../public/img/cat-duvida.png" alt="Foto do Gatinho">
            </div>
        </section>

        <section class="faq-respostas">

            <div class="faq-button">
                <a href="../controllers/FaleConosco.php"><button type="button" class="faq-FL">Fale Conosco</button></a>
            </div>

            <button type="submit" class="faq-question">
                <p class="h4">O que é o Pet Insight?</p>
            </button>
            <div class="faq-message" style="display: none;">
                <p class="text">
                    O Pet Insight é muito mais do que um site sobre animais de estimação, é um espaço dedicado ao
                    cuidado, à informação e ao bem-estar dos pets. Com conteúdos confiáveis sobre animais de estimação,
                    dicas de cuidados e curiosidades, o Pet Insight também oferece uma seleção especial de produtos
                    essenciais, como rações, sachês, brinquedos e coleiras. É o lugar ideal para quem ama animais e quer
                    o melhor para seus companheiros de quatro patas.
                </p>
            </div>

            <button type="submit" class="faq-questions">
                <p class="h4">Como posso alterar os meus dados de login?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">Na tela inicial, canto superior direito, ao lado da barra
                    de pesquisa você consegue acessar o seu perfil, lá vão estar todas as suas informaçaões e um pequeno
                    botão escrito "alterar dados" assim você pode
                    alterar facilmente.</p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Como posso alterar o meu endereço de entrega?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">Em seu perfil tem uma parte especificamente sobre seu endereço, la você pode fazer a
                    alteração facilmente</p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Como posso alterar meu número de telefone?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">Em seu perfil, onde tem todas as informações sobre você, basta aperta em "Alterar Dados"
                    e fazer as mudanças.</p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Como posso efetuar uma devolução?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">Para solicitar a devolução de um produto no Pet Insight, siga os passos abaixo:
                </p>

                <ul>
                    <li><strong>1. Entre em contato com nosso suporte pelo e-mail informando o número do pedido, motivo
                            da devolução e,
                            se possível, imagens do produto recebido (em caso de defeito ou divergência).</strong></li>
                    <li><strong>2. A devolução deve ser solicitada dentro do prazo legal de 7 dias corridos após o
                            recebimento do
                            produto, conforme o Código de Defesa do Consumidor.</strong></li>
                    <li><strong>3. Após a análise e aprovação da solicitação, você receberá as instruções para envio do
                            produto de
                            volta. O item deve estar em perfeitas condições, sem sinais de uso e com a embalagem
                            original.</strong></li>
                </ul>

                <p class="text">
                    Assim que o produto for devolvido e conferido, o estorno será processado através do Mercado Pago,
                    utilizando o mesmo meio de pagamento da compra. O prazo para reembolso pode variar conforme o método
                    utilizado.
                </p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Posso realizar a reserva de um produto que está em
                    falta?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">Atualmente, o sistema do Pet Insight não permite a reserva de produtos fora de estoque.
                    Trabalhamos com controle de inventário em tempo real, e as compras só podem ser concluídas para
                    itens disponíveis no momento. Recomendamos acompanhar a disponibilidade diretamente no site, pois os
                    estoques são atualizados regularmente.</p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Como posso cancelar uma compra?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">As transações realizadas no Pet Insight são processadas com segurança através do
                    Mercado Pago. Caso precise cancelar uma compra, é necessário que o pedido ainda não tenha sido
                    aprovado, enviado ou concluído.

                    O cancelamento pode ser solicitado diretamente pela plataforma do Mercado Pago, acessando sua conta
                    e localizando a transação desejada. Alternativamente, entre em contato com nossa equipe de suporte
                    informando o número do pedido. Após a análise, se os critérios forem atendidos, o cancelamento será
                    efetuado conforme as políticas do Mercado Pago, incluindo o estorno dos valores, quando aplicável.
                </p>
            </div>

            <button type="button" class="faq-questions">
                <p class="h4">Quais métodos de pagamento a loja possui?</p>
            </button>
            <div class="faq-messages" style="display: none;">
                <p class="text">O Pet Insight utiliza a API do Mercado Pago para processar pagamentos de forma segura e
                    eficiente. Através dessa integração, oferecemos diversos métodos de pagamento, incluindo:
                </p>

                <ul>
                    <li><strong>1. Cartões de crédito (Visa, Mastercard, American Express, Elo, entre outros)</strong>
                    </li>
                    <li><strong>2. Cartões de débito (dependendo do banco emissor)</strong></li>
                    <li><strong>3. Pix</strong></li>
                    <li><strong>4. Boleto bancário</strong></li>
                    <li><strong>5. Saldo na conta Mercado Pago</strong></li>
                </ul>

                <p class="text">
                    Todos os pagamentos são processados diretamente na plataforma do Mercado Pago, garantindo
                    criptografia, proteção de dados e confirmação em tempo real.
                </p>
            </div>


        </section>
    </main>

    <script src="../../public/js/scriptdaq.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>