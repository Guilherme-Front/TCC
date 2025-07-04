<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações Porquinho da Índia | Pet Insight</title>

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
                <a href="../views/Index.php">
                    <img class="header-img" src="../../public/img/Pet insight.png" alt="Imagem da Logo">
                </a>
            </div>

            <div class="header-link-tema">
                <?php if (isset($_SESSION['id_funcionario'])): ?>

                    <a class="header-link-none" href="../views/telaFuncionario.php">
                        <img class="user-imgF" src="../../public/img/administrador.png" alt="">
                    </a>

                <?php elseif (isset($_SESSION['id_cliente'])): ?>
                    <!-- Cliente logado - Mostrar perfil e carrinho -->
                    <a class="header-link-none" href="../views/TelaPerfil.php">
                        <img class="user-img" src="../../public/img/user.png" alt="">
                    </a>

                    <a class="header-link-none" href="../views/telaCarrinho.php">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>

                <?php else: ?>
                    <!-- Usuário não logado - Mostrar opções de login/cadastro -->
                    <a class="header-entrar" href="../views/Login.php">Entrar |</a>
                    <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

                    <a class="header-link-none" href="../views/TelaCarrinho.php">
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
            <a class="nav-link" href="../views/TelaProdutos.php">Produtos</a>
            <a class="nav-link" href="../views/Cuidados.php">Cuidados</a>
            <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
            <a class="nav-link" href="../views/Faq.php">Suporte</a>
        </div>
    </nav>

    <main>
        <section class="pet-porquinho-curiosidade">
            <div class="pet-flex-container">
                <div class="pet-container-porquinho">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Curiosidades mais peculiares sobre os Porquinhos da Índia</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Conseguem se comunicar</h3>
                        <img class="icon-comunicar" src="../../public/img/porquinho-comunicar.png" alt="">
                        </p>

                        <p class="pet-p1">
                            Esses pequenos se comunicam por diversos meios, os quais têm diferentes significados, por
                            exemplo: se cumprimentam ao tocarem o nariz, podem fingir de mortos caso haja presença de
                            predadores e até pedem atenção através da emissão de sons.
                        </p>

                        <p class="pet">
                        <h3>Comem as próprias fezes
                        </h3>

                        <img class="icon-porquinho" src="../../public/img/porquinho-fezes.png" alt="">
                        </p>
                        <p class="pet-p1">
                            São cecofágicos ou cecotrófagos, ou seja, são animais que apresentam o hábito fisiológico de
                            ingerirem suas próprias fezes. Os cecotrofos (fezes), ao serem excretados, voltam a ser
                            ingeridos, passando novamente por todo o processo digestivo, mas desta vez com um maior
                            índice de digestibilidade dos alimentos, permitindo um maior aproveitamento nutritivo deles.
                            Caso essa prática seja interrompida, perdem peso, digerem menos fibras e eliminam mais
                            minerais.</p>
                        <p class="pet">
                        <h3>Não adquira um casal</h3>
                        <img class="icon-casal" src="../../public/img/porquinho-casal.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Ao contrário do que se pensa, o ideal não é adquirir um casal para fazerem companhia, pois
                            acabam por passar mais tempo separados do que juntos devido as crias em sequência. As fêmeas
                            são capazes de engravidar logo após o parto.
                        </p>
                        <p class="pet">
                        <h3>Crescem muito rápido</h3>
                        <img class="icon-cresce" src="../../public/img/porquinho-cresce.png" alt="">

                        </p>
                        <p class="pet-p1">Outra curiosidade sobre os porquinhos-da-índia é que eles são animais de
                            crescimento muito rápido. Durante as primeiras semanas de vida eles ganham até 50 gramas por
                            semana, o que é bastante notável considerando o pequeno tamanho destes animais. Depois
                            disso, o crescimento desacelera. Mas quando o porquinho-da-índia para de crescer?
                            Usualmente, ele atinge o tamanho adulto aos 14-15 meses de idade.</p>
                        <p class="pet">
                        <h3>Podem dormir com os olhos abertos</h3>
                        <img class="icon-aberto" src="../../public/img/porquinho-olhos.png" alt="">
                        </p>
                        <p class="pet-p1">Uma curiosidade sobre os porquinhos-da-índia bastante interessante diz
                            respeito ao seu sono: apesar de terem pálpebras móveis que lhes permitem fechar os olhos,
                            muitos porquinhos- da-índia dormem com os olhos abertos. Alguns o fazem com regularidade,
                            outros apenas esporadicamente. Este é simplesmente um mecanismo de defesa que eles
                            desenvolveram para serem capazes de agir rapidamente em qualquer situação de risco, mesmo
                            quando estão dormindo.</p>
                        <p class="pet">
                        <h3>Vive quanto tempo em média?</h3>
                        <img class="icon-vive" src="../../public/img/porquinho-vive.png" alt="">
                        </p>
                        <p class="pet-p1">O Porquinho da India vive em média de 5 a 8 anos, isso varia bastante de
                            acordo com os cuidados oferecidos a ele.</p>
                    </div>
                </div>
            </div>

        </section>

        <section class="pet-porquinho-alimentação">
            <div class="pet-flex">
                <div class="pet-container-alimentação">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Alimentação</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Ração peletizada</h3>
                        </p>
                        <p class="pet-p1">
                            A ração peletizada, também chamada de alimento extrusado, é uma das bases da alimentação do
                            porquinho-da-índia. Ela deve ser oferecida diariamente, sendo que a quantidade varia de
                            acordo com o peso e a idade do seu amigo.

                            <strong>Nutrópica:</strong> Um pouco mais cara, mas não precisa dar vitamina C a mais.
                            Apenas a versão normal
                            é recomendada, a Muesli não.
                            <strong>XilaNutri:</strong> Precisa dar vitamina C a parte mas o preço é bom.
                            <strong>Megazoo:</strong> Preço médio mas não precisa dar vitamina C a parte.
                        </p>

                        <p class="pet">
                        <h3>O que eles podem comer?</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                <strong>Feno de capim e de alfafa: </strong>
                                não se surpreenda ao perceber que o porquinho-da-índia passa o dia todo mastigando. De
                                fato,
                                o organismo desses pet é “programado” para receber alimentos de maneira contínua, sendo
                                que
                                o feno é o alimento mais consumido, com papel importante na saúde dos porquinhos.
                            </p>
                            <p>
                                Obtido por meio da desidratação de gramíneas e leguminosas, o feno tem boa durabilidade
                                e é
                                muito rico em fibras. Sua ingestão é importante para manter o trânsito intestinal,
                                evitando
                                a estase, isto é, a parada dos movimentos do intestino.
                            </p>
                            <p>
                                <strong>Frutas permitidas: </strong>
                                entre o que porquinho-da-índia pode comer, algumas frutas são permitidas. Nesse caso, o
                                alimento deve ser oferecido ao porquinho-da-índia entre 2 a 3 vezes por semana. Se
                                possível,
                                varie a escolha das frutas a fim de garantir diferentes vitaminas e minerais. As frutas
                                devem estar sempre bem lavadas e fresquinhas.
                            </p>

                            <p>
                                <strong>
                                    Entre elas estão:
                                </strong>
                                pera, caqui, melancia, melão, banana, amora, mamão, morango,
                                manga e
                                goiaba.
                            </p>

                            <p>
                                <strong>Legumes e verduras,</strong>
                                as verduras pode ser oferecida diariamente ao porquinho-da-índia. Já os legumes podem
                                entrar
                                para a dieta dia sim, dia não, ou seja, de três a quatro vezes por semana.
                                Assim como deve ser feito com as frutas, legumes e verduras devem ser fornecidos frescos
                                e
                                bem lavados.
                            </p>
                            <p><strong>Feito isso, alguns dos melhores alimentos são:</strong> abobrinha, abóbora,
                                beterraba, brócolis, chuchu, couve, cenoura, rúcula, repolho, pepino e tomate.</p>
                        </div>

                        <p class="pet">
                        <h3>O que não podem comer?</h3>
                        </p>
                        <p class="pet-p1">
                            O que não podem comer?
                            Algumas comidas não são totalmente proibidas, mas devem ser dadas em poucas quantidades.
                            Elas não prejudicam a saúde em doses pequenas, mas o alto consumo pode causar sérios
                            problemas no intestino. São elas:

                        <ul class="ul-porquinho">
                            <li>Uvas</li>
                            <li>Aveia</li>
                            <li>Cevada</li>
                            <li>Sementes</li>
                            <li>Pão</li>
                            <li>Salsa</li>
                            <li>Sementes de girassol</li>
                            <li>Alface americana</li>
                            <li>Rúcula</li>
                            <li>Alface roxa</li>
                            <li>Couve-flor</li>
                            <li>Beterraba</li>
                            <li>Rabanete</li>
                        </ul>
                        </p>
                    </div>
                </div>
        </section>

        <section class="pet-porquinho-doenças">
            <div class="pet-flex">
                <div class="pet-container-doenças">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Doenças
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet-p1">
                            São os casos mais comuns em porquinhos-da-índia. O principal ponto é ter cuidado com a
                            dieta. As pessoas tendem a dar uma alimentação errada para esses animais. Eles não podem
                            comer qualquer legume ou folhagem.

                        <ul class="ul-porquinho">
                            <li>Alterações gastrointestinais parasitárias por dieta inadequada
                            </li>
                            <li>Modificações dentárias</li>
                            <li>Sarna</li>
                            <li>Anorexia</li>
                            <li>Problemas Respiratórios</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="pet-porquinho-vacinas">
            <div class="pet-flex">
                <div class="pet-container-vacinas">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Vacinação
                        </h1>

                        <div class="pet-paragrafo">

                            <p class="pet">
                            <h3>Não precisam de vacinas</h3>
                            </p>
                            <p class="pet-p1">
                                Ao contrário de muitos outros animais de estimação, como cães e gatos, os porquinhos da
                                índia não têm um programa de vacinação padrão. Até o momento, não existem vacinas
                                específicas desenvolvidas para proteger os porquinhos da índia contra doenças. No
                                entanto,
                                isso não significa que você deve negligenciar a saúde do seu porquinho da índia. Existem
                                outras medidas preventivas e práticas de cuidados essenciais que você deve seguir para
                                garantir a saúde do seu pet. Para melhores informações é de extrema importância que vá a
                                um
                                veterinário de sua confiança.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../../public/js/jsInfo.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>