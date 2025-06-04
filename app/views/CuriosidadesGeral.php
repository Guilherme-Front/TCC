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
                <a href="../views/Index.php">
                    <img class="header-img" src="../../public/img/Pet insight.png" alt="Imagem da Logo">
                </a>
            </div>

            <div class="header-link-tema">
                <?php if (isset($_SESSION['id_funcionario'])): ?>

                    <a class="header-link-none" href="../views/telaFuncionario.php">
                        <img class="user-img" src="../../public/img/engrenagem-do-usuario.png" alt="">
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
            <a class="nav-link" href="../views/telaProdutos.php">Produtos</a>
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
                        <img class="icon-cat-pe" src=".../../public/img/gato.png" alt="">
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
        </section>

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
                            movimentos. No entanto, sua visão de cores é limitada, enxergando principalmente em tons de
                            azul e amarelo.</p>
                        <p class="pet">
                        <h3>Porque giram antes de deitar?</h3>
                        <img class="icon-dog-sono" src="../../public/img/totó.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Esse comportamento foi herdado dos ancestrais lobos, e nada mais é do que uma forma de
                            defesa contra predadores. Ao girar, os cachorros conseguem sentir a direção do vento. Assim,
                            eles se deitam na direção contrária e, caso algum outro animal sinta o seu cheiro e se
                            aproxime para atacar, ele já estará em uma posição de frente, de defesa.
                        </p>
                        <p class="pet">
                        <h3>Existe uma raça que não saiba latir?</h3>
                        <img class="icon-latido" src="../../public/img/latido.png" alt="">

                        </p>
                        <p class="pet-p1">O Basenji, de origem africana, não sabe latir. Ele não chega a ser mudo porque
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
                        <p class="pet-p1">Como sabemos, cães escutam muito bem. Porém, existem sons que eles não gostam,
                            como fogos de artifício, secadores de cabelo e sirenes. Alguns cães podem até ficar mais
                            tranquilos por costume, no entanto fique sempre atento ao comportamento dele em relação a
                            esses barulhos.</p>
                    </div>
                </div>
            </div>
        </section>

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
        </section>

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
                            Esses pequenos se comunicam por diversos meios, os quais têm diferentes significados,
                            por
                            exemplo: se cumprimentam ao tocarem o nariz, podem fingir de mortos caso haja presença
                            de
                            predadores e até pedem atenção através da emissão de sons.
                        </p>

                        <p class="pet">
                        <h3>Comem as próprias fezes
                        </h3>

                        <img class="icon-porquinho" src="../../public/img/porquinho-fezes.png" alt="">
                        </p>
                        <p class="pet-p1">
                            São cecofágicos ou cecotrófagos, ou seja, são animais que apresentam o hábito
                            fisiológico de
                            ingerirem suas próprias fezes. Os cecotrofos (fezes), ao serem excretados, voltam a ser
                            ingeridos, passando novamente por todo o processo digestivo, mas desta vez com um maior
                            índice de digestibilidade dos alimentos, permitindo um maior aproveitamento nutritivo
                            deles.
                            Caso essa prática seja interrompida, perdem peso, digerem menos fibras e eliminam mais
                            minerais.</p>
                        <p class="pet">
                        <h3>Não adquira um casal</h3>
                        <img class="icon-casal" src="../../public/img/porquinho-casal.png" alt="">
                        </p>
                        <p class="pet-p1">
                            Ao contrário do que se pensa, o ideal não é adquirir um casal para fazerem companhia,
                            pois
                            acabam por passar mais tempo separados do que juntos devido as crias em sequência. As
                            fêmeas
                            são capazes de engravidar logo após o parto.
                        </p>
                        <p class="pet">
                        <h3>Crescem muito rápido</h3>
                        <img class="icon-cresce" src="../../public/img/porquinho-cresce.png" alt="">

                        </p>
                        <p class="pet-p1">Outra curiosidade sobre os porquinhos-da-índia é que eles são animais de
                            crescimento muito rápido. Durante as primeiras semanas de vida eles ganham até 50 gramas
                            por
                            semana, o que é bastante notável considerando o pequeno tamanho destes animais. Depois
                            disso, o crescimento desacelera. Mas quando o porquinho-da-índia para de crescer?
                            Usualmente, ele atinge o tamanho adulto aos 14-15 meses de idade.</p>
                        <p class="pet">
                        <h3>Podem dormir com os olhos abertos</h3>
                        <img class="icon-aberto" src="../../public/img/porquinho-olhos.png" alt="">
                        </p>
                        <p class="pet-p1">Uma curiosidade sobre os porquinhos-da-índia bastante interessante diz
                            respeito ao seu sono: apesar de terem pálpebras móveis que lhes permitem fechar os
                            olhos,
                            muitos porquinhos- da-índia dormem com os olhos abertos. Alguns o fazem com
                            regularidade,
                            outros apenas esporadicamente. Este é simplesmente um mecanismo de defesa que eles
                            desenvolveram para serem capazes de agir rapidamente em qualquer situação de risco,
                            mesmo
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
    </main>

    <script src="../../public/js/jsInfo.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>