<?php

session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações Gatos | Pet Insight</title>

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
                    <a class="header-entrar" href="../views/Login.php">Entrar |</a>
                    <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

                    <a class="header-link-none" href="../views/Login.php">
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
            <a class="nav-link" href="../views/Cuidados.php">Cuidados</a>
            <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
            <a class="nav-link" href="../views/Faq.php">Suporte</a>
        </div>
    </nav>

    <main>
        <section class="pet-info-curiosidade">
            <div class="pet-flex-container">
                <div class="pet-container-curiosidades">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Curiosidades mais peculiares sobre os felinos</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Quantos anos em média vive um gato?</h3>
                        <img class="icon-cat-black" src="../../public/img/gato-preto.png" alt="">
                        </p>

                        <p class="pet-p1">
                            Muita gente se pergunta quantos anos vive um gato? Nos dias de hoje, a expectativa de vida
                            de um gato doméstico é de 15 anos, em média.
                        </p>

                        <p class="pet">
                        <h3>Porque os gatos gostam de entrar em lugares esquisitos?</h3>

                        <img class="icon-cat" src="../../public/img/caixa-de-gato.png" alt="">
                        </p>
                        <p class="pet-p1">
                            A curiosidade sobre a natureza se trata de uma característica nata dos gatos. Adoram
                            explorar territórios, entrar em malas, sacolas, cheirar objetos e pessoas.</p>
                        <p class="pet">
                        <h3>Porque o gatos caem em pé?</h3>
                        <img class="icon-cat-pe" src="../../public/img/gato.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Os gatos são capazes de mudar de posição no ar, de modo a tocarem as patas no solo antes do
                            impacto no chão. Eles conseguem girar o corpo durante uma queda muito rápida: primeiro a
                            cabeça e os membros anteriores, depois o resto do corpo e membros posteriores. Mas isso não
                            quer dizer que não se machucam quando caem de alturas maiores, sofrendo traumas geralmente
                            em cabeça, tórax e membros.
                        </p>
                        <p class="pet">
                        <h3>Os gatos tem apego ao ambiente?</h3>
                        <img class="icon-love" src="../../public/img/bicho-de-estimacao.png" alt="">

                        </p>
                        <p class="pet-p1">Os gatos são animais de laços e rotinas, e muitos desenvolvem forte apego com
                            o
                            ambiente em que vivem. Mudanças repentinas ou movimentos podem causar estresse nos bichanos,
                            fazendo com que eles levem algum tempo para se adaptar. Por isso, é importante oferecer um
                            local seguro e familiar visando promover o bem-estar emocional e físico do animal.</p>
                        <p class="pet">
                        <h3>Porque os gatos dorme muito?</h3>
                        <img class="icon-cat-sleep" src="../../public/img/gatinha.png" alt="">
                        </p>
                        <p class="pet-p1">Em média, um gato adulto passa cerca de 12 a 16 horas por dia dormindo. No
                            entanto, essa quantidade pode variar dependendo da idade do felino, saúde e ambiente. Gatos
                            mais jovens e ativos, por exemplo, geralmente dormem um pouco menos, enquanto os mais velhos
                            e menos ativos passam mais tempo dormindo.</p>
                        <p class="pet">
                        <h3>Como é a visão dos gatos?</h3>
                        <img class="icon-cat-visao" src="../../public/img/gato-visao.png" alt="">
                        </p>
                        <p class="pet-p1">Os gatos conseguem ver mais em ambientes mais difusos, e têm uma visão
                            esférica
                            superior. Mas não conseguem ver a cor tão bem como os humanos. Os cientistas acreditam que
                            os gatos veem a erva em tom vermelho.</p>
                        <p class="pet">
                        <h3>Porque no desenhos os gatos sempre tomam leite?</h3>
                        <img class="icon-milk" src="../../public/img/tigela-para-animais-de-estimacao.png" alt="">

                        </p>
                        <p class="pet-p1">Sobre o leite nos desenhos como Tom & Jerry, sempre vemos o Tom com uma tigela
                            de leite, mas não é um alimento recomendado para dar aos gatos com frequência. Embora o
                            leite não seja tóxico, pode causar irritação no estômago, gases e diarreia.</p>
                    </div>
                </div>
            </div>

            <div class="pet-img">
                <img class="image" src="../../public/img/img-curiosidades.jpg" alt="Imagem do Gato">
            </div>
        </section>

        <section class="pet-info-alimentação">
            <div class="pet-flex">
                <div class="pet-container-alimentação">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Alimentação</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Comidas que gato não podem comer.</h3>
                        </p>
                        <p class="pet-p1">
                            Para assegurar a saúde e alimentação adequada, é importante conhecer os alimentos tóxicos
                            para o gato, a fim de mantê-los longe de alcance e evitar o consumo acidental. As principais
                            comidas proibidas são:
                            Alho, Cebola, Batata crua, Tomate, Abacate, Laranja, Limão, Uva, Leite e derivados.
                        </p>

                        <p class="pet">
                        <h3>O que pode dar além de ração?</h3>
                        </p>
                        <p class="pet-p1">
                            <strong>Sardinha</strong>, um pedacinho de carne bovina ou de frango são algumas das comidas
                            que os gatos
                            mais gostam, principalmente se estiverem fresquinhas.
                            <strong>Vegetais</strong>, Todos os vegetais devem ser bem cozidos, e os que têm mais água
                            são as melhores
                            opções. Abóbora, chuchu, beterraba… Não podem comer vegetais crus de forma alguma.
                        </p>
                        <p class="pet">
                        <h3>Melhores Rações</h3>
                        </p>
                        <p class="pet-p1">
                            <strong>PremieR Golden Frango,</strong>
                            a marca é uma das mais renomadas quando o assunto é nutrição completa aos gatinhos. A ração,
                            no sabor frango, é rica em vitaminas, minerais, fibras e proteínas, perfeita para a
                            saciedade do seu bichinho.

                            Além disso, a composição dos grãos auxilia no controle da obesidade e na saúde do trato
                            urinário, doenças muito comuns em gatos adultos e idosos. É uma escolha nutritiva, saudável
                            e completa.
                        </p>
                        <p>
                            <strong class="indent">Beneficios</strong>
                        <ul class="ul-space">
                            <li>Controle da bola de pelo </li>
                            <li>Redução do odor de fezes </li>
                            <li>Rico no aminoácido taurina </li>
                        </ul>
                        </p>

                        <p class="pet-p1">
                            <strong>Quatree Supreme Frango e Batata Doce,</strong>
                            Livre de transgênicos e com conservantes 100% naturais, as rações da marca Quatree Supreme
                            são completas quando se pensa em nutrição felina, essencialmente para gatos adultos.

                            A ração à base de frango e batata doce conta com minerais balanceados, ótimos para a saúde
                            urinária do bichano, e ajuda a evitar a tão temida bola de pelos nos gatinhos. Pode apostar
                            sem medo!
                        </p>
                        <p>
                            <strong class="indent">Beneficios</strong>
                        <ul class="ul-space">
                            <li>Fortalecimento das defesas naturais </li>
                            <li>Redução de gordura </li>
                            <li>Promoção da saúde intestinal </li>
                        </ul>
                        <p class="pet-p1">
                            <strong>Guabi Natural Frango e Arroz Integral,</strong>
                            Se estiver buscando por rações Super Premium, os produtos da linha Guabi Natural podem
                            atender perfeitamente às necessidades do seu felino predileto. Com ingredientes naturais, a
                            comida é livre de transgênicos, corantes e conservantes.

                            Além dos benefícios para a saúde e longevidade dos animais, a composição do alimento é outro
                            atrativo: 62% de origem animal, 28% à base de cereais e 10% de frutas e vegetais.

                        </p>
                        <p>
                            <strong class="indent">Beneficios</strong>
                        <ul class="ul-space">
                            <li>Bem-estar gastrointestinal </li>
                            <li>Proteína animal saudável </li>
                            <li>Alta concentração de antioxidantes </li>
                        </ul>
                        </p>

                        <p class="pet">
                        <h3>Como alimentar um filhote?
                        </h3>
                        </p>
                        <p class="pet-p1">Recomenda-se que os gatos filhotes sejam alimentados com leite materno pelos
                            primeiros 45 dias de vida. Esse alimento é suficiente para que o gato receba os anticorpos e
                            nutrientes necessários para começar a se desenvolver.

                            Durante o desmame, você deve introduzir a ração na rotina alimentar, dando preferência para
                            a ração úmida ou pastosa, que é mais fácil de mastigar nos primeiros meses de vida, enquanto
                            os dentes ainda estão crescendo. Veja as orientações abaixo:</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Idade do filhote</th>
                                    <th scope="col">Poção Diária (ração seca)</th>
                                    <th scope="col">Poção Diária (ração seca + úmida)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">2 a 3 meses</th>
                                    <td>45 a 55g</td>
                                    <td>25 a 35g + 1 sachê</td>
                                </tr>
                                <tr>
                                    <th scope="row">3 a 4 meses</th>
                                    <td>55 a 65g</td>
                                    <td>35 a 45g + 1 sachê</td>
                                </tr>
                                <tr>
                                    <th scope="row">4 a 6 meses</th>
                                    <td>65 a 70g</td>
                                    <td>45 a 50g + 1 sachê</td>
                                </tr>
                                <tr>
                                    <th scope="row">6 a 12 meses</th>
                                    <td>75g</td>
                                    <td>40 a 51g + 1 sachê</td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="pet">
                        <h3>Como alimentar um gato adulto?
                        </h3>
                        </p>
                        <p class="pet-p1">O gato é considerado adulto quando completa um ano e, nessa fase, você pode
                            manter a média de duas alimentações por dia. Procure oferecer as refeições sempre no mesmo
                            horário.

                            Evite deixar grandes quantidades nos potinhos, mesmo se você ficar fora de casa o dia todo.
                            Ao ficar muito tempo exposta, a ração perde o cheiro, a crocância e o valor nutricional, se
                            tornando menos interessante para o felino.

                            Assim como na fase anterior, o gato adulto deve consumir porções diárias compatíveis com seu
                            peso, porte, estilo de vida e outros fatores. Nosso guia alimentar oferece as seguintes
                            instruções:</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Peso</th>
                                    <th scope="col">Poção Diária (ração seca)</th>
                                    <th scope="col">Poção Diária (ração seca + úmida)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">3 a 4kg</th>
                                    <td>45 a 55g</td>
                                    <td>25 a 35g + 1 sachê</td>
                                </tr>
                                <tr>
                                    <th scope="row">4 a 5kg</th>
                                    <td>55 a 65g</td>
                                    <td>35 a 40g + 1 sachê</td>
                                </tr>
                                <tr>
                                    <th scope="row">5 a 6kg</th>
                                    <td>65 a 75g</td>
                                    <td>40 a 50g + 1 sachê</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="pet">
                        <h3>Como alimentar um gato castrado?
                        </h3>
                        </p>
                        <p class="pet-p1">Após a castração, o metabolismo do felino tende a desacelerar, fazendo com que
                            ele adote um estilo de vida mais sedentário e, consequentemente, precise consumir menos
                            calorias. Por conta disso, é importante que ele consuma uma ração específica para gatos
                            castrados. Ela possui quantidades reduzidas de carboidrato e gordura, mas conta com maiores
                            níveis de fibras e L-carnitina, uma substância que atua no metabolismo para assegurar a
                            queima de gorduras. Nosso guia alimentar oferece as seguintes
                            instruções:</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Peso</th>
                                    <th scope="col">Baixa Atividade Física</th>
                                    <th scope="col">No peso ideal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">3 a 4kg</th>
                                    <td>35 a 45g</td>
                                    <td>45 a 55g</td>
                                </tr>
                                <tr>
                                    <th scope="row">4 a 5kg</th>
                                    <td>45 a 52g</td>
                                    <td>55 a 65g</td>
                                </tr>
                                <tr>
                                    <th scope="row">5 a 6kg</th>
                                    <td>52 a 60g</td>
                                    <td>65 a 73g</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </section>

        <section class="pet-info-doenças">
            <div class="pet-flex">
                <div class="pet-container-doenças">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Doenças
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Leucemia felina (FeLV)</h3>
                        </p>
                        <p class="pet-p1">
                            Esta doença afeta, geralmente, filhotes e gatinhos jovens. É uma das doenças mais graves
                            pela facilidade de transmissão e alcance de danos que provoca, incluindo a morte. Provoca
                            tumores em diferentes órgãos do corpo do gato afetado, inflamação dos gânglios, anorexia,
                            perda de peso, anemia e depressão. É uma doença viral e sua transmissão se da pelo contato
                            com os fluidos corporais, por exemplo, lutas de gatos podem provocar alguma ferida que
                            sangra, quando eles se limpam e lambem e acabem entrando em contato com fluidos corporais de
                            outros gatos. Se partilharem uma caixa de areia também podem entrar em contato com urina e
                            fezes de outros gatos. A melhor forma de prevenir esta doença é vacinando e evitando que o
                            seu gatinho entre em contato com outros animais já doentes.
                        </p>

                        <p class="pet">
                        <h3>Panleucopenia felina</h3>
                        </p>
                        <p class="pet-p1">
                            Também conhecida como cinomose felina, enterite ou gastroenterite infecciosa. A infecção
                            ocorre pelo contato com fluidos corporais de um animal infectado. Os sintomas mais comuns
                            incluem febre e, mais tarde, hipotermia, vômitos, diarreia, depressão, fraqueza,
                            desidratação e anorexia. Realizando exames de sangue, é possível verificar uma queda
                            significativa dos glóbulos brancos e/ou leucócitos. Esta doença viral afeta filhotes e
                            gatinhos jovens de forma mais grave. O tratamento consiste em hidratação intravenosa e
                            antibióticos, entre outras coisas que dependem do avanço da doença e do estado do gato
                            doente. Esta doença é mortal, então é importante separar o gato doente dos demais. A
                            prevenção consiste em vacinar e evitar o contato do seu pet com outros gatos já doentes.
                        </p>
                        <p class="pet">
                        <h3>Calicivirose ou calicivírus felino</h3>
                        </p>
                        <p class="pet-p1">
                            Esta doença viral felina é provocada por um picornavírus. A sintomatologia inclui espirros,
                            febre, muita salivação e até úlceras e bolhas na boca e na língua. É uma doença generalizada
                            com alta mortalidade. Compõe entre 30 e 40% dos casos de infecções respiratórias nos gatos.
                            O animal afetado que consiga superar a doença passa a transportador, podendo transmitir a
                            doença.
                        </p>
                        <p class="pet">
                        <h3>Peritonite infecciosa (PIF)</h3>
                        </p>
                        <p class="pet-p1">Neste caso, o vírus que provoca a doença é um coronavírus que afeta mais gatos
                            jovens e, ocasionalmente, idosos. Pode ser transmitido por via transplacentária ou através
                            do contato direto e contínuo de secreções orais e respiratórias. A eliminação do vírus se dá
                            pela saliva, urina e fezes. É mais comum em zonas com muitos gatos como criadouros, colônias
                            de rua e outros lugares onde existe convívio de muitos gatos. Os sintomas mais notórios
                            incluem febre, anorexia, aumento do volume abdominal e acumulação de líquido no mesmo. Isto
                            acontece porque o vírus ataca os glóbulos brancos, provocando uma inflamação das membranas
                            das cavidades torácicas e abdominais. A PIF ainda não tem cura, infelizmente. No entanto,
                            existem tratamentos paliativos que podem ajudar a prolongar a vida dos gatos com PIF e
                            deixá-lo o mais confortável possível. A progressão da doença pode ser reduzida com
                            antibióticos, antinflamatórios e quimioterápicos. Apenas pode ser administrado um tratamento
                            sintomático de apoio para aliviar as dores e desconfortos que o gato apresenta.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="pet-info-vacinas">
            <div class="pet-flex">
                <div class="pet-container-vacinas">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Vacinação
                        </h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Vacinas para gatos: qual a sua importância?</h3>
                        </p>
                        <p class="pet-p1">
                            As vacinas para gato são responsáveis por produzir anticorpos – células de defesa – no
                            organismo do felino, ou seja, são uma forma de prevenção contra diversas doenças, como a
                            FELV (leucemia felina) e outras que são muito comuns entre os bichanos. E olha, a vacina não
                            protege somente os gatinhos não, hein? Hoje, já sabemos que diversas enfermidades podem
                            passar do pet para as pessoas e a vacinação garante também uma convivência saudável entre
                            pets e humanos.

                            Existem 3 tipos de vacinas para os gatos: V3, V4 e V5.
                        </p>

                        <p class="pet">
                        <h3>Vacina V3 para gatos</h3>
                        </p>
                        <p class="pet-p1">
                            A vacina V3 felina (vacina tríplice – trivalente) protege o pet contra duas doenças
                            respiratórias, rinotraqueíte felina e a calicivirose felina, além da panleucopenia felina
                            (que pode causar danos ao sistema digestivo e sanguíneo).
                        </p>
                        <p class="pet">
                        <h3>Vacina v4 para gatos</h3>
                        </p>
                        <p class="pet-p1">
                            A vacina V4 felina (vacina quádrupla) irá trazer os mesmos benefícios da V3, além de
                            proteger contra a clamidiose, que é uma doença infecciosa, que atinge os olhos dos animais e
                            pode acometer os seres humanos.
                        </p>
                        <p class="pet">
                        <h3>Vacina v5 para gatos</h3>
                        </p>
                        <p class="pet-p1">Já a vacina V5 felina (vacina quíntupla) é a mais completa: traz os mesmos
                            benefícios da V4, e também protege contra a FELV (leucemia felina).</p>
                        <p class="pet">
                        <h3>Vacina de raiva para gatos </h3>
                        </p>
                        <p class="pet-p1">Além das vacinas V3, V4 e V5, os gatos também precisam ser vacinados contra a
                            raiva, já que essa doença pode levar o pet à morte, além de poder contaminar seres humanos.

                            Além disso, é sempre importante lembrar que as vacinas devem ser anuais. Não basta vacinar
                            seu amiguinho apenas quando filhote, pois a imunidade não é vitalícia.
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