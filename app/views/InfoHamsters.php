<?php

session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações Cachorros | Pet Insight</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel="stylesheet" href="../../public/css/styleInfo.css">

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

            <div class="search">
                <label for="search">
                    <input type="search" class="TL-inp" name="search" id="search" placeholder="Pesquise aqui">
                </label>
            </div>

            <div class="header-link-tema">
                <?php if (isset($_SESSION['id_cliente'])): ?>
                    <!-- Ícone de usuário e carrinho (usuário logado) -->
                    <a class="header-link-none" href="../views/TelaPerfil.html">
                        <img class="user-img" src="../../public/img/user.png" alt="">
                    </a>

                    <form method="post" action="../controllers/logout.php" style="display:inline;">
                        <button type="submit" class="header-button-logout" aria-label="logout">Sair</button>
                    </form>

                    <a class="header-link-none" href="../views/TelaCarrinho.html">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>


                <?php else: ?>
                    <!-- Entrar, Cadastro e Carrinho (usuário não logado) -->
                    <a class="header-entrar" href="../views/Login.html">Entrar |</a>
                    <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

                    <a class="header-link-none" href="../views/TelaCarrinho.html">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>
                <?php endif; ?>

                <button class="header-button" id="button-tema" type="submit" aria-label="tema"><img class="header-tema"
                        src="../../public/img/tema.png" alt="Foto Mudança de Tema"></button>
            </div>
        </div>
    </header>

    <nav>
        <div class="nav_wrap">
            <a class="nav-link" href="../views/QuemSomos.php">Quem Somos</a>
            <a class="nav-link" href="../views/TelaProdutos.php">Produtos</a>
            <a class="nav-link" href="#">Cuidados</a>
            <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
            <a class="nav-link" href="../views/Faq.php">Suporte</a>
        </div>
    </nav>

    <main>
        <section class="pet-ham-curiosidade">
            <div class="pet-flex-container">
                <div class="pet-container-ham">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Curiosidades mais peculiares sobre os Hamsters</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Hamsters aprendem seu próprio nome</h3>
                        <img class="icon-ham" src="../../public/img/espantado.png" alt="">
                        </p>

                        <p class="pet-p1">
                            Não. Você não entendeu errado! Este pequeno roedor é muito inteligente, e pode aprender seu
                            próprio nome. Especialistas dizem que basta que ele ouça o apelido com bastante frequência.
                            Se você quiser estimular, fique repetindo o nome de seu amigo próximo a ele. Em breve, ele
                            vai aprender e começar a atender quando for chamado.
                        </p>

                        <p class="pet">
                        <h3>Eles adoram um friozinho</h3>

                        <img class="icon-frio" src="../../public/img/hamster.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Os hamsters são originários de locais frios, como a China e a Mongólia. Por isso, eles
                            adoram temperaturas baixas e não se dão bem em locais muito quentes. Portanto, evite que seu
                            amigo fique exposto ao sol, principalmente durante o verão. Além disso, deixe a casinha de
                            hamster longe de fontes de calor, como aquecedores e outros eletrodomésticos.</p>
                        <p class="pet">
                        <h3>Eles são um pouco cegos</h3>
                        <img class="icon-cego" src="../../public/img/hamster-loiro.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Os olhos pretos dos hamsters podem ser fofos, mas eles não são muito bons para enxergar.
                            Estudos mostram que a visão desses roedores é bem ruim, e muitas vezes eles utilizam os
                            bigodes para se orientar.
                        </p>
                        <p class="pet">
                        <h3>Quanto tempo em média vive um Hamster?</h3>
                        <img class="icon-feliz" src="../../public/img/hamster-feliz.png" alt="">

                        </p>
                        <p class="pet-p1">Com os cuidados certos, seu amigo roedor poderá viver de dois a três anos,
                            sendo sempre uma ótima companhia. Por essa razão, é importante saber como cuidar de um
                            hamster. Porque, afinal, eles dependem de uma alimentação equilibrada, ambiente limpo e
                            higienizado, além muitos outros cuidados.</p>
                        <p class="pet">
                        <h3>Porque eles enchem a bochecha de comida?</h3>
                        <img class="icon-bochecha" src="../../public/img/hamster-comendo.png" alt="">
                        </p>
                        <p class="pet-p1">As bochechas dos hamsters são muito fofas, além de serem uma das
                            características que tornam ele tão encantador. Mas saiba que tanta fofura não é à toa. As
                            bochechas, na verdade, são espaços dedicados a armazenar comida!
                            Se você convive com um hamster, provavelmente já observou eles se encherem de comida,
                            ficando bem bochechudos, certo? Esse é um comportamento muito comum, pois é uma forma de
                            guardar comida para depois ou levar alimento para sua família.</p>
                    </div>
                </div>
            </div>

            <div class="pet-img">
                <img class="image-ham" src="../../public/img/imagem-ham.webp" alt="Imagem do Hamster">
            </div>
        </section>

        <section class="pet-ham-alimentação">
            <div class="pet-flex">
                <div class="pet-container-alimentação">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Alimentação</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>O que não podem comer</h3>
                        </p>
                        <p class="pet-p1">
                            <strong>Alimentos ultraprocessados:</strong>
                            Eles são repletos de gorduras saturadas, conservantes e aromatizantes, sendo bastante
                            prejudiciais para a espécie.
                            Além disso, os industrializados contribuem para a sobrecarga de órgãos vitais e para o
                            surgimento da obesidade e da diabetes.

                            <strong>Frutas cítricas:</strong>
                            Embora ricas em vitaminas, as frutas ácidas como a laranja, o limão e a tangerina podem
                            provocar lesões na boca ou no sistema gastrointestinal do hamster quando ingeridas em
                            excesso. Na dúvida, dê preferência a opções mais seguras, como pera e maçã.

                            <strong>Leite e derivados:</strong>
                            Assim como ocorre com a maior parte dos mamíferos, o hamster vai perdendo a capacidade de
                            metabolizar a lactose conforme cresce. Por isso, o leite e seus derivados estão entre os
                            alimentos prejudiciais para esse roedor.
                            Aliás, o hamster tem dificuldade de digerir alimentos como leite de caixa, queijos e
                            iogurtes. Eles podem desencadear diarreias, desconforto abdominal, entre outros problemas
                            digestivos devido não apenas à lactose, mas também à alta quantidade de gordura. Por isso,
                            esses itens também são proibidos.
                        </p>

                        <p class="pet">
                        <h3>Alimentos que podem comer</h3>
                        </p>
                        <p class="pet-p1">
                            Os hamsters podem se alimentar de outros tipos de alimentos, como:

                            <strong>Verduras:</strong> brócolis, acelga, repolho, chicória e couve-flor.
                            <strong>Legumes:</strong> abóbora, cenoura e nabo.
                            <strong>Frutas:</strong> banana, maçã, morango e pêra.

                            No caso das frutas, devemos nos atentar com as que possuem sementes (maçã e pêra,
                            especificamente). Essas sementes contêm uma uma substância chamada cianeto que, se ingerida
                            em excesso, pode levar o hamster à morte.
                        </p>
                        <p class="pet">
                        <h3>Melhores Rações</h3>
                        </p>
                        <p class="pet-p1">
                            A Ração <strong>Nutrópica</strong> é uma opção muito bacana para seu peludo e com uma
                            aceitação legal pelos pais de pets são a Ração NuTrópica Hamster Natural e Ração Nutrópica
                            Muesli. Essa última possui um pouco mais de gordura, devido as sementes em sua formulação.
                        </p>

                        <p class="pet-p1">
                            A <strong>Zootekna</strong> é uma linha com tendência ao sabores de frutas, as rações da
                            Zootekna são alimentos Super Premium que também podem ser utilizados como snacks. Os
                            pequenos adoram as frutas cristalizadas e rodelas de maçã secas presentes na Ração Zootekna
                            Super Premium Real Friends com Frutas. Já a Ração Zootekna Super Premium para Hamster
                            Snacks, é uma ótima fonte de vitaminas e minerais.
                        </p>

                        <p class="pet-p1">
                            A ração <strong>Nutricon Nutriroedores</strong> Nutriroedores é um alimento completo,
                            extrusado em formato atrativo para hamster, gerbil, topolino e outros pequenos roedores de
                            estimação. Formulada com ingredientes de alta qualidade e digestibilidade, trata-se de uma
                            ração para pequenos roedores, e não apenas para hamsters, por isso, recomenda-se que você
                            faça uma mistura com outras rações ou mesmo complemente com outros tipos de alimento.
                        </p>
                    </div>


                    <div class="carousel-container-ham">
                        <div class="carousel">
                            <div class="carousel-item item1">
                                <img class="img-carousel" src="../../public/img/guabi-natural.jpg" alt="">
                            </div>
                            <div class="carousel-item item2">
                                <img class="img-carousel" src="../../public/img/img-racao.jpg" alt="">
                            </div>
                            <div class="carousel-item item3">
                                <img class="img-carousel" src="../../public/img/guabi-natural.jpg" alt="">
                            </div>
                            <div class="carousel-item item4">
                                Item 4
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section class="pet-ham-doenças">
            <div class="pet-flex">
                <div class="pet-container-doenças">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Doenças
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Quais são as principais doenças de hamster?</h3>
                        </p>
                        <p class="pet-p1">
                            Mesmo que o pequeno roedor não fique doente com frequência, as principais causas das idas ao
                            veterinário são: resfriados, bronquites, pneumonia, diarreia, prisão de ventre, infecções e
                            abscessos.

                            O abscesso em hamster, por exemplo, é um tipo de protuberância de pus debaixo da pele do
                            animal, que costuma ficar avermelhada e um pouco elevada, causando dor ao roedor.
                            Geralmente, isso acontece por conta de alguma infecção bacteriana que não foi bem cuidada.
                            Se perceber essas características, peça a ajuda de um veterinário.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="pet-ham-vacinas">
            <div class="pet-flex">
                <div class="pet-container-vacinas">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Vacinação
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Vacinas de Hamsters</h3>
                        </p>
                        <p class="pet-p1">
                            Hamsters, em geral, não precisam tomar vacinas. A prevenção de doenças se dá por meio de uma
                            alimentação adequada e da higiene:

                        <ul class="ul">
                            <li>Cuidados com o hamster</li>
                            <li>Manter a gaiola do hamster limpa</li>
                            <li>Oferecer comida de qualidade</li>
                            <li>Proporcionar água limpa</li>
                            <li>Proporcionar brinquedos</li>
                            <li>Proporcionar uma roda de exercícios</li>
                            <li>Levar o hamster ao veterinário pelo menos uma vez por ano</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../../public/js/jsInfo.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>