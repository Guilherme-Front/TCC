<?php

session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem Somos| Pet Insight</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel="stylesheet" href="../../public/css/styleInfo.css?v=<?= time() ?>">

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body>
    <header class="header">
        <div class="header_container">
            <div class="header-titulo">
                <a href="../views/Index.php"><img class="header-img" src="../../public/img/Pet insight.png"
                        alt="Imagem da Logo"></a>
            </div>


            <div class="header-link-tema">
                <?php if (isset($_SESSION['id_cliente'])): ?>
                <!-- Ícone de usuário e carrinho (usuário logado) -->
                <a class="header-link-none" href="../views/TelaPerfil.php">
                    <img class="user-img" src="../../public/img/user.png" alt="">
                </a>

                <form method="post" action="../controllers/logout.php" style="display:inline;">
                    <button type="submit" class="header-button-logout" aria-label="logout">Sair</button>
                </form>

                <a class="header-link-none" href="../views/TelaCarrinho.php">
                    <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                </a>

                <?php else: ?>
                <!-- Entrar, Cadastro e Carrinho (usuário não logado) -->
                <a class="header-entrar" href="../views/Login.html">Entrar |</a>
                <a class="header-cadastro" href="../controllers/telaCadastro.php">Cadastro</a>

                <a class="header-link-none" href="../views/Login.html">
                    <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                </a>
                <?php endif; ?>

                <button class="header-button" id="button-tema" type="submit" aria-label="tema">
                    <img class="header-tema" src="../../public/img/tema.png" alt="Foto Mudança de Tema">
                </button>
            </div>
        </div>
    </header>

    <nav>
        <div class="nav_wrap">
            <a class="nav-link" href="../views/QuemSomos.php">Quem Somos</a>
            <a class="nav-link" href="../views/telaProdutos.php">Produtos</a>
            <a class="nav-link" href="../views/Cuidados.php">Cuidados</a>
            <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
            <a class="nav-link" href="../views/Faq.php">Suporte</a>
        </div>
    </nav>

    <main>
        <section class="quem-somos">
            <div class="quem-somos-container">
                <div class="quem-somos-flex">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Quem Somos</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet-p1">
                            A Pet Insight é uma empresa recente no mercado pet, mas conta com uma equipe de
                            especialistas qualificados e parcerias de confiança. Nosso objetivo é promover uma melhor
                            qualidade de vida para todos os animais domésticos, oferecendo informações precisas e
                            produtos de excelência.

                            Mais do que um site sobre pets, a Pet Insight é um espaço dedicado ao cuidado, à informação
                            e ao bem-estar animal. Disponibilizamos conteúdos confiáveis sobre cães, gatos, coelhos,
                            hamsters e porquinhos-da-índia, com dicas de alimentação, vacinação, curiosidades e saúde.
                            Também oferecemos uma seleção de produtos essenciais, como rações, sachês, brinquedos,
                            coleiras e itens de higiene, garantindo o que há de melhor para os seus companheiros de
                            quatro patas.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../../public/js/tema.js"></script>
</body>

</html>