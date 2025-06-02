<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Principal | Pet Insight</title>

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet'
    href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
  <link rel="stylesheet" href="../../public/css/stylePrincipal.css?v=<?= time() ?>">

  <!-- Logo na aba do site  -->
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body class="fl-body">
  <?php if (isset($_SESSION['toast'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        <?php if ($_SESSION['toast']['type'] === 'error'): ?>
          error("<?= $_SESSION['toast']['message'] ?>", "linear-gradient(to right, #cd1809, #a01006)");
        <?php else: ?>
          Toastify({
            text: "<?= $_SESSION['toast']['message'] ?>",
            duration: 3500,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
          }).showToast();
        <?php endif; ?>
      });
    </script>
    <?php unset($_SESSION['toast']); ?>
  <?php endif; ?>
  <header class="header">
    <div class="header_container">
      <div class="header-titulo">
        <img class="header-img" src="../../public/img/Pet insight.png" alt="Imagem da Logo">
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
      <a class="nav-link" href="../views/TelaProdutos.php">Produtos</a>
      <a class="nav-link" href="../views/Cuidados.php">Cuidados</a>
      <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
      <a class="nav-link" href="../views/Faq.php">Suporte</a>
    </div>
  </nav>

  <main>
    <section class="TL_carrosel">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="../../public/img/foto-promoções.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="../../public/img/foto-adoção.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="../../public/img/foto-castração.png" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev"
          aria-label="sla">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next"
          aria-label="sla">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
      </div>
    </section>

    <article class="tl_paragrafo">
      <p class="tl-p">Aqui você pode adquirir informações essenciais para ajudá-lo a conhecer melhor o seu amigo e
        proporcionar a ele uma vida mais feliz e saudável.</p>
    </article>

    <section class="carousel-3">
      <div class="swiper-container-novo" id="carousel">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="cart-gatos">
              <div class="cart-img">
                <img class="cart-cat-img" src="../../public/img/cat-card.png" alt="Imagem do Gatinho">
              </div>
              <div class="cart-info">
                <h4 class="cart-titulo-gatos">Gatos</h4>
                <p class="cart-p-gatos">Descubra hábitos curiosos dos felinos e dicas para uma vida saudável.</p>
              </div>
              <div class="cart-button">
                <a href="../views/InfoGatos.php"><button type="submit" class="cart-next">Saiba Mais</button></a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="cart-gatos">
              <div class="cart-img">
                <img class="cart-cat-img" src="../../public/img/pastor.jpg" alt="Imagem do Cachorrinho">
              </div>
              <div class="cart-info">
                <h4 class="cart-titulo-dog">Cachorros</h4>
                <p class="cart-p-gatos">Como cuidar do seu melhor amigo e mantê-lo ativo, saudável e feliz.</p>
              </div>
              <div class="cart-button">
                <a href="../views/InfoDogs.php"><button type="submit" class="cart-next">Saiba Mais</button></a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="cart-gatos">
              <div class="cart-img">
                <img class="cart-cat-img" src="../../public/img/ham-card.png" alt="Imagem do Hamster">
              </div>
              <div class="cart-info">
                <h4 class="cart-titulo-ham">Hamsters</h4>
                <p class="cart-p-gatos">Cuidados com o seu amiguinho e como mantê-lo saudável e feliz.</p>
              </div>
              <div class="cart-button">
                <a href="../views/InfoHamsters.php"><button type="submit" class="cart-next">Saiba Mais</button></a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="cart-gatos">
              <div class="cart-img">
                <img class="cart-cat-img" src="../../public/img/coelho-card.jpeg" alt="Imagem do Hamster">
              </div>
              <div class="cart-info">
                <h4 class="cart-titulo-coelho">Coelhos</h4>
                <p class="cart-p-gatos">Dicas de como cuidar do seu amigo e mantê-lo saudável e feliz.</p>
              </div>
              <div class="cart-button">
                <a href="../views/InfoCoelhos.php"><button type="submit" class="cart-next">Saiba Mais</button></a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="cart-gatos">
              <div class="cart-img">
                <img class="cart-cat-img" src="../../public/img/pi-card.jpeg" alt="Imagem do Hamster">
              </div>
              <div class="cart-info">
                <h4 class="cart-titulo-PI">Porquinho da India</h4>
                <p class="cart-p-gatos">Como cuidar do seu amigo peludo e mantê-lo ativo, saudável e feliz.</p>
              </div>
              <div class="cart-button">
                <a href="../views/InfoPorquinho.php"><button type="submit" class="cart-next">Saiba Mais</button></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button class="prev-btn" onclick="moveCarousel('prev')"><img id="prev-tema"
          src="../../public/img/angulo-esquerdo.png" alt="Imagem Setinha Esquerda" aria-label="prev"></button>
      <button class="next-btn" onclick="moveCarousel('next')"><img id="next-tema"
          src="../../public/img/angulo-direito.png" alt="Imagem Setinha Direita" aria-label="next"></button>
    </section>

    <section class="marca">
      <div class="titulo_marca">
        <h2 class="titulo-responsive">Nossas marcas e parcerias</h2>
        <p class="p-marca">Nossos produtos são de altíssima qualidade, provenientes das melhores empresas.</p>
      </div>

      <div class="marcas">
        <img class="img-size" src="../../public/img/Beeps.png" alt="Imagem da marca Beeps">
        <img class="img-size-whiskas" src="../../public/img/Whiskas.png" alt="Imagem da marca Whiskas">
        <img class="img-size-zee" src="../../public/img/zee.dog.png" alt="Imagem da marca Zee Dog">
        <img class="img-size-love" src="../../public/img/Pet-Love.png" alt="Imagem da marca Pet Love">
        <img class="img-size-casa" src="../../public/img/CasaTosador.png" alt="Imagem da marca Casa do Tosador">
      </div>

    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/scriptPrincipal.js"></script>
  <script src="../../public/js/tema.js"></script>
</body>

<footer class="footer">
  <div class="container">
    <div class="coluna">
      <div class="h5-rede">
        <h5 class="nr">Nossas Redes Sociais</h5>
      </div>

      <div class="icon-rede">
        <img src="../../public/img/whatsapp.png" alt="Imagem do Whatsap" class="img-zap">
        <img src="../../public/img/facebook.png" alt="Imagem do Facebook" class="img-face">
        <img src="../../public/img/instagram.png" alt="Imagem do Instagram" class="img-insta">
      </div>
    </div>

    <div class="coluna">
      <div class="titulo_pag">
        <h5>Faça sua compra com segurança</h5>
      </div>
      <p class="p-pag">Para maior segurança na realização da sua compra, temos parceria com o Mercado Pago, a líder em
        pagamentos online, garantindo uma experiência segura e confiável.</p>

      <div class="marcas">
        <img src="../../public/img/MercadoPago.png" alt="" class="img-pag">
      </div>
    </div>

    <div class="coluna">
      <div class="links">
        <a class="links-footer" href="../views/QuemSomos.php">Quem Somos</a>
        <a class="links-footer" href="#">Promoções</a>
        <a class="links-footer" href="../views/FaleConosco.html">Fale Conosco</a>
      </div>
    </div>

    <div class="coluna">
      <div class="cont">
        <p>Contato</p>
        <p>Estr. da Baronesa, 1695 - Jardim Angela, São Paulo - SP, 04941-175</p>
        <p>11 99999-9999</p>
      </div>
    </div>
  </div>
</footer>

</html>