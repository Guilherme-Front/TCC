<?php

session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Produtos | Pet Insight</title>


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet'
    href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
  <link rel="stylesheet" href="../../public/css/styleProdutos.css?v=<?= time() ?>">

  <!-- Logo na aba do site  -->
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body class="fl-body">
  <header class="header">
    <div class="header_container">
      <div class="header-titulo">
        <a href="../controllers/Index.php"><img class="header-img" src="../../public/img/Pet insight.png"
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
          <a class="header-link-none" href="../controllers/TelaPerfil.php">
            <img class="user-img" src="../../public/img/user.png" alt="">
          </a>

          <form method="post" action="../controllers/logout.php" style="display:inline;">
            <button type="submit" class="header-button-logout" aria-label="logout">Sair</button>
          </form>

          <a class="header-link-none" href="../controllers/TelaCarrinho.php">
            <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
          </a>


        <?php else: ?>
          <!-- Entrar, Cadastro e Carrinho (usuário não logado) -->
          <a class="header-entrar" href="../controllers/Login.php">Entrar |</a>
          <a class="header-cadastro" href="../controllers/telaCadastro.php">Cadastro</a>

          <a class="header-link-none" href="../controllers/TelaCarrinho.php">
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
      <a class="nav-link" href="#">Quem Somos</a>
      <a class="nav-link" href="../controllers/TelaProdutos.php">Produtos</a>
      <a class="nav-link" href="#">Cuidados</a>
      <a class="nav-link" href="../controllers/CuriosidadesGeral.php">Curiosidades</a>
      <a class="nav-link" href="../controllers/Faq.php">Suporte</a>
    </div>
  </nav>

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

  <section class="categorias">

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

    <article class="categoria">
      <div class="circulo"></div>
      <p class="tipo">Tipo</p>
    </article>

  </section>

  <section class="produtos">

    <div class="grid-container">

      <article class="produto">
        <a href="../views/InformacaoProduto.html">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>
      <!-- Linha 2 -->

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>

      <article class="produto">
        <a href="#">
          <div class="img-produto">
            <img src="../../public/img/casinha.png" alt="casinha de cachorro">
          </div>
          <p>Casa para cachorro preto e azul</p>
          <p>R$ 109,90</p>
        </a>
      </article>
    </div>
    </div>
  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../public/js/scriptPrincipal.js"></script>
  <script src="../../public/js/tema.js"></script>
</body>

</html>