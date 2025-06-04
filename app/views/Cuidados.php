<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curiosidades Gerais | Pet Insight</title>

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
                <?php if (isset($_SESSION['id_funcionario'])): ?>

                    <!-- Funcionário logado - Mostrar perfil e área do funcionário -->
                    <a class="header-link-none" href="../views/telaFuncionario.php">
                        <img class="user-img" src="../../public/img/engrenagem-do-usuario.png" alt="">
                    </a>

                <?php elseif (isset($_SESSION['id_cliente'])): ?>
                    <!-- Cliente logado - Mostrar perfil e carrinho -->
                    <a class="header-link-none" href="../views/TelaPerfil.php">
                        <img class="user-img" src="../../public/img/user.png" alt="">
                    </a>

                    <a class="header-link-none" href="../views/TelaCarrinho.php">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>

                <?php else: ?>
                    <!-- Usuário não logado - Mostrar opções de login/cadastro -->
                    <a class="header-entrar" href="../views/Login.php">Entrar |</a>
                    <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

                    <a class="header-link-none" href="../views/Login.php">
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
        <section class="cuidados-gato">
            <div class="pet-flex-container">
                <div class="pet-container-curiosidades">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Cuidados com os Gatos</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Comidas que gatos não podem comer.</h3>
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

        <section class="cuidados-dogs">
            <div class="pet-flex-container">
                <div class="pet-container-dog">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Cuidados com os Cachorros</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Alimentos que cachorros não podem comer
                        </h3>
                        </p>
                        <p class="pet-p1">Abacate: O abacate possui uma substância chamada “persina”, que não causa
                            nenhum tipo de mal-estar às pessoas, mas é nocivo para eles, podendo causar problemas
                            intestinais, como vômitos e diarreia.
                            Chocolate: O cacau é composto por teobromina, que provoca estímulo cerebral e aumento da
                            atividade cardíaca, resultando em arritmias. Fora isso, também o doce também é composto por
                            cafeína e é rico em açúcar, que pode deixar seu cão obeso ou diabético.
                            Leite: Não só o leite, mas os laticínios podem causar diarreia e muitos outros problemas
                            voltados ao sistema digestivo. Isso porque os cachorros não possuem lactase (enzima
                            responsável por digerir a lactose) o bastante para o cão realizar a digestão corretamente.
                            Alho, cebola e cebolinha: Esses três alimentos contém a toxina N-propil dissulfeto, que
                            provoca vômitos, anemias, sangue na urina, fraqueza, respiração ofegante e frequência
                            cardíaca elevada. Portanto, alimentos com esses temperos, como o arroz, devem ser evitados.
                        </p>

                        <p class="pet">
                        <h3>Além de ração o que podemos dar para os cachorros?</h3>
                        </p>
                        <p class="pet-p1">
                            Banana: ajuda na função intestinal. Oferecer em pequenas porções.

                            Beterraba: contribui para o aumento da imunidade do pet. Deve ser servida cozida e sem
                            temperos.

                            Cenoura: rica em vitamina A, é um ótimo antioxidante para o organismo dos cachorros,

                            Maçã: atua como probiótico e regula a glicemia. Deve ser oferecido em pequenos pedaços, com
                            a casca e sem sementes

                            Manga: contradizendo ditos populares, o cachorro pode, sim, comer Manga! Ela é rica em
                            Vitamina C. Deve ser oferecida sem casca e sem caroço.

                            Tomates: Rico vitaminas A, B e C e fibras, o tomate pode fazer parte da alimentação crus e
                            sem sementes.
                        </p>

                        <p class="pet">
                        <h3>Raiva Canina</h3>
                        </p>
                        <p class="pet-p1">
                            A raiva canina está no topo das doenças de cachorro mais perigosas
                            A raiva canina lidera a lista de doenças de cachorro mais graves, isso porque a patologia
                            não tem cura e pode causar danos irreversíveis. Prevenir a raiva em cachorro é uma questão
                            de vida ou morte. A raiva é uma questão de saúde pública provocada por um vírus que atua no
                            sistema neurológico, causando encefalite, um tipo de inflamação cerebral perigosa. É por
                            isso que o cachorro com raiva apresenta comportamentos fora do comum, como:
                            Agressividade
                            Salivação excessiva
                            Hipertermia (aumento da temperatura corporal)
                            Latidos excessivos
                            Comportamentos fora do comum
                            Fotofobia
                            Convulsão
                            Paralisia
                        </p>

                        <p class="pet">
                        <h3>leptospirose canina</h3>
                        </p>
                        <p class="pet-p1">
                            A leptospirose canina é causada pelo contato com água contaminada
                            A leptospirose canina é uma doença infecciosa aguda causada por uma bactéria que está
                            presente na urina de alguns animais, principalmente os ratos. Então os cachorros que entram
                            em contato com a água contaminada com essa urina, como em enchentes ou poças de esgoto,
                            podem ser infectados com a doença. O ciclo da leptospirose começa com a bactéria penetrando
                            a pele do animal. Em seguida, ela entra na corrente sanguínea e causa lesões em diversos
                            órgãos. Os principais sintomas são:
                            Perda de peso
                            Febre
                            Desidratação
                            Dor abdominal
                            Lesões na pele
                            Urina com sangue

                        </p>
                        <p class="pet">
                        <h3>Cinomose</h3>
                        </p>
                        <p class="pet-p1">
                            A cinomose é uma doença viral muito perigosa que pode atingir o sistema respiratório,
                            gastrointestinal ou neurológico do pet. Ela é extremamente contagiosa e normalmente a
                            transmissão ocorre pelo contato de um animal saudável com qualquer secreção de um cão
                            contaminado. Em relação aos sintomas da cinomose, eles são um pouco inespecíficos, pois
                            podem se manifestar de maneiras diferentes no animal. Mas alguns pequenos sinais podem
                            acender o alerta dos tutores, como:
                            Descamação da pele
                            Secreção ocular
                            Dificuldade respiratória
                            Tosse
                            Vômitos
                            Diarreia
                            Contração musculares involuntárias
                            Convulsão

                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cuidados-ham">
            <div class="pet-flex-container">
                <div class="pet-container-ham">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Cuidados com os Hamsters</h1>
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

        <section class="cuidados-coelho">
            <div class="pet-flex-container">
                <div class="pet-container-coelhos">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Cuidados com os Coelhos</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>Pode dar comidas além de ração?</h3>
                        </p>
                        <p class="pet-p1">
                            Sim! Aqui em baixo estão algumas indicações.
                            Feno
                            É essencial para cuidar da alimentação do bichinho já que ajuda o sistema digestivo dos
                            coelhos. Também deve ser oferecido diariamente. Como tem pouco valor nutricional, não é
                            necessário se preocupar com porções: deixe seu orelhudo comer à vontade!

                            <strong>Verduras,</strong>
                            as verduras também servem como comida para coelho. Para animais adultos, o ideal é comer
                            verduras todos os dias. Mas atenção: nem todas as verduras são benéficas para a saúde
                            dos peludinhos. Algumas possuem substâncias que podem ser laxantes. O ideal é buscar
                            vegetais com folhas escuras, que costumam ser mais seguros.
                            <strong>Rúcula:</strong> os orelhudos adoram o sabor amargo e picante da rúcula.
                            <strong>Couve:</strong> ofereça apenas crua e sem tempero.

                            <strong>Legumes,</strong>
                            os coelhos adoram legumes, mas eles não fazem parte de sua dieta cotidiana. Como legumes
                            crus possuem uma digestão mais complexa, a ingestão deve ocorrer uma vez a cada dois
                            dias.
                            <strong>Folhas de brócolis:</strong> evite dar os talos, pois podem causar gases no seu pet.
                            <strong>Cenouras:</strong> ocasionalmente, os coelhos podem, sim, comer cenoura!
                            <strong>Beterraba:</strong> deverá ser oferecida crua e sempre sem tempero.

                            <strong>Frutas,</strong>
                            também são sensíveis para os nossos amiguinhos, pois possuem açúcar e carboidratos.
                            Devem ser oferecidas como petiscos uma ou duas vezes por semana.
                            <strong>Morango:</strong> além dos coelhos adorarem, é uma fruta pequena, o que favorece a
                            ingestão.
                            <strong>Manga:</strong> outra fruta que faz sucesso entre os dentuços. Descasque e cuidado
                            com o
                            caroço.
                            <strong>Kiwi:</strong> os coelhos gostam dessa fruta azedinha. Não se esqueça de descascar.
                        </p>
                        <p class="pet">
                        <h3>Alimentos proibidos para coelhos</h3>
                        </p>
                        <p class="pet-p1">
                            Além da carne, existem alguns outros alimentos que entram na lista do que coelho não pode
                            comer. Alguns deles são:
                            batata e inhame: esses legumes contêm alto teor de solanina, um elemento tóxico para o
                            animal. Além disso, são alimentos calóricos para um coelho, por isso, devem ser eliminados
                            da dieta;
                            arroz e pão: possuem excesso de carboidratos, que é prejudicial ao sistema digestivo do
                            coelho. Por isso, são alimentos que não devem estar na dieta do animal;
                            lácteos: são os alimentos derivados do leite, muito prejudiciais ao sistema digestivo do
                            coelho, por isso, não podem ser incorporados à dieta.
                        </p>

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

        <section class="cuidados-porquinho">
            <div class="pet-flex-container">
                <div class="pet-container-porquinho">
                    <div class="pet-h1">
                        <h1 class="pet-titulo">Cuidados com os Porquinhos da Índia</h1>
                    </div>

                    <div class="pet-paragrafo">
                        <p class="pet">
                        <h3>O que eles podem comer?</h3>
                        </p>
                        <p class="pet-p1">
                            <strong>Feno de capim e de alfafa,</strong>
                            não se surpreenda ao perceber que o porquinho-da-índia passa o dia todo mastigando. De fato,
                            o organismo desses pet é “programado” para receber alimentos de maneira contínua, sendo que
                            o feno é o alimento mais consumido, com papel importante na saúde dos porquinhos.

                            Obtido por meio da desidratação de gramíneas e leguminosas, o feno tem boa durabilidade e é
                            muito rico em fibras. Sua ingestão é importante para manter o trânsito intestinal, evitando
                            a estase, isto é, a parada dos movimentos do intestino.

                            <strong>Frutas permitidas,</strong>
                            entre o que porquinho-da-índia pode comer, algumas frutas são permitidas. Nesse caso, o
                            alimento deve ser oferecido ao porquinho-da-índia entre 2 a 3 vezes por semana. Se possível,
                            varie a escolha das frutas a fim de garantir diferentes vitaminas e minerais. As frutas
                            devem estar sempre bem lavadas e fresquinhas.

                            Entre elas estão maçã, pera, caqui, melancia, melão, banana, amora, mamão, morango, manga e
                            goiaba.

                            <strong>Legumes e verduras,</strong>
                            as verduras pode ser oferecida diariamente ao porquinho-da-índia. Já os legumes podem entrar
                            para a dieta dia sim, dia não, ou seja, de três a quatro vezes por semana.

                            Assim como deve ser feito com as frutas, legumes e verduras devem ser fornecidos frescos e
                            bem lavados. Feito isso, alguns dos melhores alimentos são: abobrinha, abóbora, beterraba,
                            brócolis, chuchu, couve, cenoura, rúcula, repolho, pepino e tomate.
                        </p>

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
    </main>

    <script src="../../public/js/tema.js"></script>
    <script src="../../public/js/jsInfo.js"></script>
</body>

</html>