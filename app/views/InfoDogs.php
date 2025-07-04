<?php

session_start();

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
                        <img class="user-imgF" src="../../public/img/administrador.png" alt=""" alt="">
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
        <section class="pet-dog-curiosidade">
            <div class="pet-flex-container">
                <div class="pet-container-dog">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Curiosidades mais peculiares sobre os cachorros</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Cachorros também sonham</h3>
                        <img class="icon-dog-sonho" src="../../public/img/amor.png" alt="">
                        </p>

                        <p class="pet-p1">
                            Você já observou seu cãozinho enquanto ele dorme? Muitos cachorros podem emitir sons
                            baixinhos, uma espécie de latido ou mexer as patinhas, o focinho e até mudar de posição
                            bruscamente enquanto dormem.
                        </p>

                        <p class="pet">
                        <h3>Visão limitada</h3>

                        <img class="icon-dog" src="../../public/img/dog.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Além do olfato aguçado, os cães têm uma boa audição e visão adaptada para detectar
                            movimentos. No entanto, sua visão de cores é limitada, enxergando principalmente em tons
                            de
                            azul e amarelo.</p>
                        <p class="pet">
                        <h3>Porque giram antes de deitar?</h3>
                        <img class="icon-dog-sono" src="../../public/img/totó.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Esse comportamento foi herdado dos ancestrais lobos, e nada mais é do que uma forma de
                            defesa contra predadores. Ao girar, os cachorros conseguem sentir a direção do vento.
                            Assim,
                            eles se deitam na direção contrária e, caso algum outro animal sinta o seu cheiro e se
                            aproxime para atacar, ele já estará em uma posição de frente, de defesa.
                        </p>
                        <p class="pet">
                        <h3>Existe uma raça que não saiba latir?</h3>
                        <img class="icon-latido" src="../../public/img/latido.png" alt="">

                        </p>
                        <p class="pet-p1">O Basenji, de origem africana, não sabe latir. Ele não chega a ser mudo
                            porque
                            consegue se comunicar por meio de uivos longos e agudos.</p>
                        <p class="pet">
                        <h3>Tempo de vida de um cachorro</h3>
                        <img class="icon-cat-sleep" src="../../public/img/cao.png" alt="">
                        </p>
                        <p class="pet-p1">Em média, cães podem viver entre 10 e 13 anos, podendo variar para mais ou
                            menos de acordo com suas características. Cachorros de grande porte tendem a viver menos
                            devido a uma grande quantidade de radicais livres presentes em seu organismo.</p>
                        <p class="pet">
                        <h3>Porque cachorros são sensiveis a barulhos altos?</h3>
                        <img class="icon-fogos" src="../../public/img/fogos.png" alt="">
                        </p>
                        <p class="pet-p1">Como sabemos, cães escutam muito bem. Porém, existem sons que eles não
                            gostam,
                            como fogos de artifício, secadores de cabelo e sirenes. Alguns cães podem até ficar mais
                            tranquilos por costume, no entanto fique sempre atento ao comportamento dele em relação
                            a
                            esses barulhos.</p>
                    </div>
                </div>
            </div>

        </section>

        <section class="pet-dog-alimentação">
            <div class="pet-flex-container">
                <div class="pet-container-alimentação">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Alimentação</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Além de ração o que podemos dar para os cachorros?</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                <strong>Banana:</strong> ajuda na função intestinal. Oferecer em pequenas porções.
                            </p>
                            <p>
                                <strong>Beterraba:</strong> contribui para o aumento da imunidade do pet. Deve ser
                                servida cozida e sem
                                temperos.
                            </p>
                            <p>
                                <strong>Cenoura:</strong> rica em vitamina A, é um ótimo antioxidante para o
                                organismo
                                dos cachorros.
                            </p>
                            <p>
                                <strong>Maçã:</strong> atua como probiótico e regula a glicemia. Deve ser oferecido
                                em
                                pequenos pedaços,
                                com a casca e sem sementes.
                            </p>
                            <p>
                                <strong>Manga:</strong> contradizendo ditos populares, o cachorro pode, sim, comer
                                Manga! Ela é rica em
                                Vitamina C. Deve ser oferecida sem casca e sem caroço.
                            </p>
                            <p>
                                <strong>Tomates:</strong> Rico vitaminas A, B e C e fibras, o tomate pode fazer
                                parte da
                                alimentação crus e sem sementes.
                            </p>

                        </div>

                        <p class="pet">
                        <h3>Como alimentar um cachorro?</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                A alimentação do cachorro precisa ser feita de forma correta, considerando o estado
                                de
                                saúde
                                atual, a raça, o peso e o porte do animal, e claro, seguindo as recomendações
                                veterinárias.
                                A quantidade de ração por animal é variável, bem como quantas refeições são
                                necessárias
                                por
                                dia.
                            </p>
                            <p>

                            </p>
                            <p><strong>
                                    Geralmente, se segue estas orientações:
                                </strong></p>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Idade do filhote</th>
                                        <th scope="col">Porção Diária (ração seca)</th>
                                        <th scope="col">Porção Diária (ração seca + úmida)</th>
                                        <th scope="col">Frequência Recomendada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Até 8 semanas</th>
                                        <td>Aleitamento materno</td>
                                        <td>Aleitamento materno</td>
                                        <td>Somente leite materno</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2 a 3 meses</th>
                                        <td>45 a 55g</td>
                                        <td>25 a 35g + 1 sachê</td>
                                        <td>4 vezes ao dia</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3 a 4 meses</th>
                                        <td>55 a 65g</td>
                                        <td>35 a 45g + 1 sachê</td>
                                        <td>4 vezes ao dia</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4 a 6 meses</th>
                                        <td>65 a 70g</td>
                                        <td>45 a 50g + 1 sachê</td>
                                        <td>3 vezes ao dia</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6 a 12 meses</th>
                                        <td>75g</td>
                                        <td>40 a 51g + 1 sachê</td>
                                        <td>2 vezes ao dia</td>
                                    </tr>
                                </tbody>
                            </table>

                            <p>
                                A quantidade de ração em cada porção vai depender do porte do animal, peso e a marca de
                                ração oferecida, já que algumas dão mais saciedade. O ideal é verificar a embalagem da
                                marca. A alimentação não deve ser deixada à disposição do cachorro o dia todo, isso pode
                                gerar problemas como sobrepeso e obesidade.
                            </p>

                        </div>
                        <p class="pet">
                        <h3>Melhores Rações</h3>
                        </p>
                        <p class="pet-p1">
                            A Ração <strong>Guabi Narual Cordeiro e Aveia</strong> para raças médias é uma opção
                            Super
                            Premium para cães adultos. Com uma fórmula rica em ingredientes naturais, ela oferece
                            proteínas de alta qualidade, como o cordeiro, e o benefício da aveia, que auxilia na
                            digestão.
                        </p>

                        <p class="pet-p1">
                            A <strong>Ração Bionatural Prime</strong> para cães de raças médias e grandes adultos,
                            sabor
                            frango, é uma
                            opção Super Premium Natural desenvolvida com a orientação de veterinários.
                            Com ingredientes de alta qualidade, essa ração oferece diversos benefícios para a saúde
                            do
                            seu pet, como a redução do tártaro, proteção e reforço das articulações com condroitina
                            e
                            glucosamina, além de promover um intestino equilibrado com a combinação de prebióticos e
                            probióticos.
                            Sem corantes ou aromatizantes artificiais, é uma opção nutritiva e balanceada,
                            disponível em
                            diferentes embalagens para atender às necessidades do seu cão.
                        </p>

                        <p class="pet-p1">
                            A <strong>Ração Biofresh Super Premium</strong> é indicada para cães adultos de porte
                            mini
                            ou pequeno. Ela é usada principalmente quando há necessidades especiais com a saúde
                            digestiva do animal, mas também pode ser servida no dia a dia.


                        </p>

                        <p class="pet">
                        <h3>Alimentos que cachorros não podem comer
                        </h3>
                        </p>
                        <div class="pet-p1">
                            <p><strong>Abacate:</strong> O abacate possui uma substância chamada “persina”, que não
                                causa nenhum tipo de mal-estar às pessoas, mas é nocivo para eles, podendo causar
                                problemas intestinais, como vômitos e diarreia.</p>

                            <p><strong>Chocolate:</strong> O cacau é composto por teobromina, que provoca estímulo
                                cerebral e aumento da atividade cardíaca, resultando em arritmias. Fora isso, também
                                o
                                doce é composto por cafeína e é rico em açúcar, que pode deixar seu cão obeso ou
                                diabético.</p>

                            <p><strong>Leite:</strong> Não só o leite, mas os laticínios podem causar diarreia e
                                muitos
                                outros problemas voltados ao sistema digestivo. Isso porque os cachorros não possuem
                                lactase (enzima responsável por digerir a lactose) o bastante para a digestão
                                correta.
                            </p>

                            <p><strong>Alho, cebola e cebolinha:</strong> Esses três alimentos contêm a toxina
                                N-propil
                                dissulfeto, que provoca vômitos, anemias, sangue na urina, fraqueza, respiração
                                ofegante
                                e frequência cardíaca elevada. Portanto, alimentos com esses temperos, como o arroz,
                                devem ser evitados.</p>
                        </div>

                    </div>
                </div>
        </section>

        <section class="pet-dog-doenças">
            <div class="pet-flex">
                <div class="pet-container-doenças">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Doenças
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Raiva Canina</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                A raiva canina está no topo das doenças de cachorro mais perigosas
                                A raiva canina lidera a lista de doenças de cachorro mais graves, isso porque a
                                patologia
                                não tem cura e pode causar danos irreversíveis. Prevenir a raiva em cachorro é uma
                                questão
                                de vida ou morte. A raiva é uma questão de saúde pública provocada por um vírus que
                                atua
                                no
                                sistema neurológico, causando encefalite, um tipo de inflamação cerebral perigosa.
                            </p>
                            <p>
                                <strong>
                                    É por
                                    isso que o cachorro com raiva apresenta comportamentos fora do comum, como:
                                </strong>
                            </p>
                            Agressividade,
                            salivação excessiva,
                            hipertermia (aumento da temperatura corporal),
                            latidos excessivos,
                            comportamentos fora do comum,
                            fotofobia,
                            convulsão e
                            Paralisia
                        </div>

                        <p class="pet">
                        <h3>Leptospirose canina</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                A leptospirose canina é uma doença infecciosa aguda causada por uma bactéria que
                                está
                                presente na urina de alguns animais, principalmente os ratos. Então os cachorros que
                                entram
                                em contato com a água contaminada com essa urina, como em enchentes ou poças de
                                esgoto,
                                podem ser infectados com a doença.
                            </p>
                            <p>
                                O ciclo da leptospirose começa com a bactéria penetrando a pele do animal. Em
                                seguida, ela entra
                                na corrente sanguínea e causa lesões em diversos órgãos.
                            </p>
                            <p>
                                <strong>Os principais sintomas são:</strong>
                            </p>
                            Perda de peso,
                            febre,
                            desidratação,
                            dor abdominal,
                            lesões na pele e
                            urina com sangue.
                        </div>

                        <p class="pet">
                        <h3>Cinomose</h3>
                        </p>
                        <div class="pet-p1">
                            <p>
                                A cinomose é uma doença viral muito perigosa que pode atingir o sistema
                                respiratório,
                                gastrointestinal ou neurológico do pet. Ela é extremamente contagiosa e normalmente
                                a
                                transmissão ocorre pelo contato de um animal saudável com qualquer secreção de um
                                cão
                                contaminado. Em relação aos sintomas da cinomose, eles são um pouco inespecíficos,
                                pois
                                podem se manifestar de maneiras diferentes no animal.
                            </p>
                            <p>
                                <strong>Mas alguns pequenos sinais podem acender o alerta dos tutores,
                                    como:</strong>
                            </p>
                            Descamação da pele,
                            secreção ocular,
                            dificuldade respiratória,
                            tosse,
                            vômitos,
                            diarreia,
                            contrações musculares involuntárias e
                            convulsão.
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="pet-dog-vacinas">
            <div class="pet-flex">
                <div class="pet-container-vacinas">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Vacinação
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Vacinas para cachorros: qual a sua importância?</h3>
                        </p>
                        <p class="pet-p1">
                            Vacinar o cachorro é importante para prevenir doenças graves e infectocontagiosas, que
                            podem
                            ser fatais. A vacinação também ajuda a desenvolver o sistema imunológico do animal.
                        </p>

                        <p class="pet">
                        <h3>VANGUARD® HTLP - ÓCTUPLA (V8)</h3>
                        </p>
                        <p class="pet-p1">
                            Auxilia na prevenção da cinomose, leptospirose (sorovares Canicola, lcterohaemorrhgiae),
                            parvovirose, coronavirose, hepatite infecciosa canina, adenovirose e parainfluenza.
                        </p>
                        <p class="pet">
                        <h3>ANGUARD® PLUS - DÉCTUPLA (V10)</h3>
                        </p>
                        <p class="pet-p1">
                            Auxilia na prevenção da cinomose, leptospirose (sorovares Canicola, lcterohaemorrhagiae,
                            Pomona e Grippotyphosa), parvovirose, coronavirose, hepatite infecciosa canina,
                            adenovirose
                            e parainfluenza.
                        </p>
                        <p class="pet">
                        <h3>GIARDIAVAX, GIARDIAVAX4 e BRONCHIGUARD - INJETÁVEL</h3>
                        </p>
                        <p class="pet-p1">Indicada como auxiliar na prevenção de infecções pela Bordetella
                            bronchiseptica para cães acima de 8 semanas de idade. Na primeira vacinação, devem ser
                            administradas 2 doses pela via subcutãnea com intervalo de 2 a 4 semanas entre elas. Os
                            reforços devem ser anuais.</p>
                        <p class="pet">
                        <h3>BRONCHI-SHIELD* III - INTRANASAL</h3>
                        </p>
                        <p class="pet-p1">Indicada na prevenção contra o adenovírus canino tipo 2, o vírus da
                            parainfluenza canina e na Bordetella bronchiseptica para cães acima de 8 semanas de
                            idade.
                            Uma dose única da vacina pela via intranasal é suficiente para garantir a proteção por 1
                            ano, reforço anual.
                        </p>
                        <p class="pet">
                        <h3>VANGUARD® B ORAL</h3>
                        </p>
                        <p class="pet-p1">Indicada como auxiliar na prevenção infecciosa respiratória canina
                            (traqueobronquite infecciosa canina ou tosse dos canis) causada por em cães sadios a
                            partir
                            de 8 semanas de idade. Uma dose única da vacina pela via oral é o suficiente para
                            garantir a
                            proteção por 1 anos. O reforço é anual.
                        </p>
                        <p class="pet">
                        <h3>DEFENSOR®</h3>
                        </p>
                        <p class="pet-p1">Defensor® é uma vacina inativada, indicada para vacinação de cães e gatos
                            sadios como auxiliar na prevenção da infecção pelo vírus da raiva. É indicada para cães
                            e
                            gatos a partir de 3 meses de idade.
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