<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações Coelhos | Pet Insight</title>

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
                        <img class="user-imgF" src="../../public/img/administrador.png" alt="" alt="">
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
        <section class="pet-coelhos-curiosidade">
            <div class="pet-flex-container">
                <div class="pet-container-coelhos">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Curiosidades mais peculiares sobre os Coelhos</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>São independentes em relação à higiene</h3>
                        <img class="icon-coelho" src="../../public/img/coelho-higiene.png" alt="">
                        </p>

                        <p class="pet-p1">
                            Coelhos se mostram bastante independentes em relação à sua higiene e não apreciam ambientes
                            sujos. Eles se limpam sozinhos, assim como os gatos. Banhos não são recomendados e podem ser
                            prejudiciais, exceto em casos de sujeira excessiva. Nesses casos, recomenda-se usar água
                            morna e produtos específicos.
                        </p>

                        <p class="pet">
                        <h3>Coelhos comem as próprias fezes
                        </h3>

                        <img class="icon-fezes" src="../../public/img/coelho-fezes.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Parte do material fecal que produzem é conhecido como “cecotrofos”, ingeridos assim que
                            depositados, já que ainda existem nutrientes que podem ser aproveitados pelos coelhos. Por
                            isso, é comum que os vejamos comer as próprias fezes.</p>
                        <p class="pet">
                        <h3>Dentes de coelho nunca param de crescer</h3>
                        <img class="icon-dentes" src="../../public/img/coelho-dentes.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Apesar de não serem considerados roedores e sim lagomorfos, coelhos compartilham essa
                            característica que dependem do ato de roer. Por isso mesmo, seus dentes precisam ser
                            continuamente desgastados com a ajuda de uma alimentação apropriada e de brinquedos para
                            evitar problemas de saúde.
                        </p>
                        <p class="pet">
                        <h3>Como são os olhos e a visão do coelho?</h3>
                        <img class="icon-visao" src="../../public/img/coelho-visao.png" alt="">

                        </p>
                        <p class="pet-p1">Sua visão periférica chega a quase 360º. Isso significa que você nunca vai
                            conseguir chegar de surpresa até ele. Os olhos de coelho possuem um único ponto cego, na
                            frente de seu nariz. Porém, isso não é um problema para o dentuço, já que ele possui uma
                            infinidade de pelos táteis nessa região.
                            Por se tratar de uma presa, a visão do coelho é excelente. Ele enxerga bem tanto de dia
                            quanto à noite e tem perfeita noção de profundidade e distância, necessárias para ver um
                            predador se aproximando.</p>
                        <p class="pet">
                        <h3>Quais cores o coelho enxerga?</h3>
                        <img class="icon-olhos" src="../../public/img/coelho-olhos.png" alt="">
                        </p>
                        <p class="pet-p1">Sabemos que esses animais enxergam diferentes tons porque eles possuem as
                            células responsáveis por captar cores nos olhos, que são os cones.
                            Os humanos possuem três variedades desses cones, já os coelhos, somente duas. Isso significa
                            que eles enxergam com uma paleta mais reduzida de cores do que nós. E quais cores os coelhos
                            enxergam? Acredita-se que eles vejam verde, azul e suas variações.</p>
                    </div>
                </div>
            </div>

        </section>

        <section class="pet-coelhos-alimentação">
            <div class="pet-flex">
                <div class="pet-container-alimentação">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Alimentação</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Melhores Rações</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                A ração deve compor a maior parte de sua dieta. Também conhecida como alimentos
                                extrusados,
                                esse produto é feito especialmente para os orelhudos. Ofereça diariamente, no mínimo 3
                                vezes
                                ao dia.
                            </p>
                            <p><strong>
                                    Abaixo estão as rações com melhor qualidade!
                                </strong></p>

                            <p>
                                <strong>Ração Nutrópica Coelho Filhote</strong>
                                Essa é uma das rações mais recomendadas para coelhos filhotes, pois contém mais de 30
                                ingredientes diferentes incluindo alfafa e vários tipos de grãos integrais como aveia,
                                ervilha, linhaça e trigo, que juntos proporcionam os níveis ideais dos nutrientes
                                necessários para a saúde, beleza, bem-estar e vitalidade do coelho.
                            </p>

                            <p>
                                <strong>Principais benefícios:</strong>
                            </p>

                            <ul class="ul-coelho">
                                <li>100% natural</li>
                                <li>Mais brilho à pelagem, e pele saudável</li>
                                <li>Mais saúde e vitalidade vai ajudar na disposição do dia a dia</li>
                                <li>Muito mais saboroso por ser natural</li>
                            </ul>
                        </div>

                        <div class="pet-p1">

                            <p>
                                <strong>Ração Nutricon Nutrirabbit</strong>
                                É um alimento completo, extrusado, formulado especificamente para atender às exigências
                                nutricionais de coelhos de todas as idades. Possui alto valor nutritivo, contendo em sua
                                fórmula ingredientes de excelente qualidade, além de conter prebiótico e ser enriquecido
                                com
                                complexos vitamínicos e minerais.
                            </p>
                            <p>
                                <strong>Principais benefícios:</strong>
                            </p>

                            <ul class="ul-coelho">
                                <li>Alimento completo extrusado para coelhos tradicionais e mini coelhos</li>
                                <li>Possui alto valor nutritivo</li>
                                <li>Contém vitamina C proporcionando uma vida mais saudável ao seu coelho</li>
                            </ul>
                        </div>

                        <div class="pet-p1">

                            <p>
                                <strong>Ração Megazoo para Coelhos Filhotes</strong>
                                A ração Megazoo não contém casca de ovo, possui minerais quelatados, glutamina e ômega 3
                                de
                                cadeia longa (DHA). Alimento 100% natural à base de alecrim, se destaca como a primeira
                                ração super premium de coelhos da América Latina – possui um alto controle de qualidade.
                            </p>
                            <p>
                                <strong>Principais benefícios:</strong>
                            </p>

                            <ul class="ul-coelho">
                                <li>Formato mais compacto para desgaste dos dentes</li>
                                <li>Minerais quelatados</li>
                                <li>Prebióticos Mos e Fos</li>
                                <li>Ômega 3 de cadeia longa – DHA</li>
                                <li>100 % natural antioxidante à base de alecrim</li>
                            </ul>
                        </div>

                        <p class="pet">
                        <h3>Pode dar comidas além de ração?</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                Sim! Aqui em baixo estão algumas indicações.
                                Feno
                                É essencial para cuidar da alimentação do bichinho já que ajuda o sistema digestivo dos
                                coelhos. Também deve ser oferecido diariamente. Como tem pouco valor nutricional, não é
                                necessário se preocupar com porções: deixe seu orelhudo comer à vontade!
                            </p>
                            <p>
                                <strong>Verduras:</strong> as verduras também servem como comida para coelho. Para
                                animais adultos, o ideal é comer
                                verduras todos os dias. Mas atenção: nem todas as verduras são benéficas para a saúde
                                dos peludinhos. Algumas possuem substâncias que podem ser laxantes. O ideal é buscar
                                vegetais com folhas escuras, que costumam ser mais seguros.
                            </p>
                            <p>
                                <strong>Rúcula:</strong> os orelhudos adoram o sabor amargo e picante da rúcula.
                            </p>
                            <p>
                                <strong>Couve:</strong> ofereça apenas crua e sem tempero.
                            </p>
                            <p>
                                <strong>Legumes:</strong>
                                os coelhos adoram legumes, mas eles não fazem parte de sua dieta cotidiana. Como legumes
                                crus possuem uma digestão mais complexa, a ingestão deve ocorrer uma vez a cada dois
                                dias.
                            </p>
                            <p>
                                <strong>Folhas de brócolis:</strong> evite dar os talos, pois podem causar gases no seu
                                pet.
                            </p>
                            <p>
                                <strong>Cenouras:</strong> ocasionalmente, os coelhos podem, sim, comer cenoura!
                            </p>
                            <p>
                                <strong>Beterraba:</strong> deverá ser oferecida crua e sempre sem tempero.
                            </p>
                            <p>
                                <strong>Frutas:</strong>
                                também são sensíveis para os nossos amiguinhos, pois possuem açúcar e carboidratos.
                                Devem ser oferecidas como petiscos uma ou duas vezes por semana.
                            </p>

                            <p>
                                <strong>Morango:</strong> além dos coelhos adorarem, é uma fruta pequena, o que favorece
                                a
                                ingestão.
                            </p>
                            <p>
                                <strong>Manga:</strong> outra fruta que faz sucesso entre os dentuços. Descasque e
                                cuidado
                                com o
                                caroço.
                            </p>
                            <p>
                                <strong>Kiwi:</strong> os coelhos gostam dessa fruta azedinha. Não se esqueça de
                                descascar.
                            </p>
                        </div>
                        <p class="pet">
                        <h3>Alimentos proibidos para coelhos</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                Além da carne, existem alguns outros alimentos que entram na lista do que coelho não
                                pode
                                comer.
                            </p>
                            <p><strong> Alguns deles são:</strong></p>
                            <p>
                                <strong>Batata e inhame:</strong> esses legumes contêm alto teor de solanina, um
                                elemento
                                tóxico para o
                                animal. Além disso, são alimentos calóricos para um coelho, por isso, devem ser
                                eliminados
                                da dieta;
                            </p>
                            <p>
                                <strong>Arroz e pão:</strong> possuem excesso de carboidratos, que é
                                prejudicial ao sistema digestivo do
                                coelho.
                            </p>
                            <p>
                                <strong>lácteos:</strong> são os alimentos derivados do leite, muito prejudiciais ao sistema digestivo do
                            coelho, por isso, não podem ser incorporados à dieta.

                            </p>
                        </div>
                    </div>
                </div>
        </section>

        <section class="pet-coelhos-doenças">
            <div class="pet-flex">
                <div class="pet-container-doenças">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Doenças
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet-p1">
                            São duas as doenças principais contra as quais todos os coelhos devem ser vacinados:
                        </p>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Mixomatose</h3>
                        </p>

                        <p class="pet-p1">
                            A mixomatose é uma infeção provocada pelo vírus da mixomatose. Tanto os coelhos selvagens
                            como os domésticos estão em risco. Estes animais podem ficar infetados seja por contacto
                            direto ou indireto, através de mosquitos e outros insetos. No caso dos coelhos domésticos, a
                            transmissão por forragem infetada tem também um papel importante.
                            Nódulos nos tecidos subcutâneos são típicos desta doença. As zonas genitais e da cabeça são
                            especialmente afetadas. Além do mais, febre e descargas purulentas no nariz e nos olhos são
                            comuns.
                            A maioria dos coelhos afetados morre em cerca de duas semanas, pois não são capazes de
                            ingerir comida suficiente devido ao enorme inchaço.
                        </p>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Doença hemorrágica viral do coelho</h3>
                        </p>

                        <p class="pet-p1">
                            A doença hemorrágica viral do coelho (DHV) constitui uma ameaça especialmente insidiosa. A
                            maior parte dos coelhos afetados morre subitamente ou dentro de poucas horas sem apresentar
                            quaisquer sintomas. Caso surjam sintomas, os principais são hemorragia, febre e dificuldades
                            respiratórias. A doença é desencadeada pelo vírus da DHV, da família dos calicivírus.
                            Tal como na mixomatose, a transmissão da DHV dá-se diretamente, através do contato com
                            coelhos infectados, ou indiretamente, através de insetos ou objetos (comedouros ou outros
                            acessórios da gaiola).
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="pet-coelhos-vacinas">
            <div class="pet-flex">
                <div class="pet-container-vacinas">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Vacinação
                        </h1>
                    </div>

                    <table class="table table-bordered" id="table-coelhos">
                        <thead>
                            <tr>
                                <th scope="col">Vacina</th>
                                <th scope="col">Mixomatose</th>
                                <th scope="col">DHV</th>
                                <th scope="col">Vacinação Primária</th>
                                <th scope="col">Reforço</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Filavac VHD K C+V</th>
                                <td></td>
                                <td>x</td>
                                <td>a partir das 10 semanas</td>
                                <td>anual</td>
                            </tr>
                            <tr>
                                <th scope="row">Nobivac Myxo-RHD Plus</th>
                                <td>x</td>
                                <td>x</td>
                                <td>a partir das 5 semanas</td>
                                <td>anual</td>
                            </tr>
                            <tr>
                                <th scope="row">Rika-Vacc Myxo sc</th>
                                <td>x</td>
                                <td></td>
                                <td>a partir das 4 semanas</td>
                                <td>bianual</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script src="../../public/js/jsInfo.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>