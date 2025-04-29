<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="../../public/css/perfil.css?v=<?= time() ?>">
  <!-- Logo na aba do site  -->
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">

  <title>Tela de Perfil | Pet Insight</title>
</head>

<body>

  <header> 
    <a href="../controllers/Index.php">
      <img class="logo" src="../../public/img/Pet insight.png" alt="logo">
    </a>
  </header>

  <div class="voltarP">
    <a href="../controllers/Index.php">
      <img class="botao-voltar" src="../../public/img/voltar.png" alt="botao-voltar" />
    </a>
    <h2 class="minha-conta">Minha conta</h2>

    <div class="carrinho">
      <a href="../views/TelaCarrinho.php">
        <img class="carrinho-compras" src="../../public/img/carrinho.png" alt="carrinho de compras" />
      </a>
    </div>
  </div>

  <main>

    <aside>

      <nav class="menu-lateral">

        <ul>
          <li class="item-menu ativo">
            <a href="#">
              <span class="icon"><img class="icons-img" src="../../public/img/file-user.png" alt="usuário" id="file"></span>
              <span class="txt-link">Meus dados</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="#">
              <span class="icon"><img class="icons-img" src="../../public/img/order-history.png" alt="pedidos" id="order"></span>
              <span class="txt-link">Meus pedidos</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="#">
              <span class="icon"><img class="icons-img" src="../../public/img/suggestion.png" alt="suporte" id="mapa"></span>
              <span class="txt-link">Suporte</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="#">
              <span class="icon"><img class="icons-img" src="../../public/img/map-marker-home.png" alt="endereço" id="house"></span>
              <span class="txt-link">Endereço</span>
            </a>
          </li>

          <li class="item-menu-logoff">
            <a href="#">
              <span class="icon"><img class="icons-img" src="../../public/img/exit.png" alt="logoff"></span>
              <span class="txt-logoff">Sair da conta</span>
            </a>
          </li>
        </ul>
      </nav>

    </aside>

    <section>

      <div class="perfil">

        <div class="img-txt">
          <img class="gato" src="../../public/img/gato.jpg" alt="gato" />
          <p class="boas-vindas">Olá <strong>Jubiscreuda!</strong></p>
        </div>

        <button class="enviar-foto" type="submit">Enviar foto</button>

        <div class="dados-pessoais">

          <div class="dados">
            <label>Nome completo</label>
            <input type="text" disabled placeholder="Jubiscreuda">

            <label>Email</label>
            <input type="text" disabled placeholder="Jubiscreuda@gmail.com">

            <label>Senha</label>
            <input type="password" disabled placeholder="*********">
          </div>

          <div class="dados">
            <label>Data de nascimento</label>
            <input type="text" disabled placeholder="00/00/0000">

            <label>Telefone</label>
            <input type="text" disabled placeholder="11 95455335">

            <button class="alterar-dados">Alterar dados</button>
          </div>
        </div>
      </div>

    </section>

  </main>

  <script src="../../public/js/tema.js"></script>
  <script src="../../public/js/scriptPerfil.js"></script>
</body>

</html>