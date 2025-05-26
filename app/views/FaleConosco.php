<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fale Conosco | Pet Insight</title>

    <link rel="stylesheet" href="../../public/css/stylefaq.css?v=<?= time() ?>">

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body class="fl-body">
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

        <?php else: ?>
          <!-- Usuário não logado - Mostrar opções de login/cadastro -->
          <a class="header-entrar" href="../views/Login.php">Entrar |</a>
          <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

        <?php endif; ?>

      </div>
    </div>
  </header>

    <main class="fl_body">
        <section class="fl-flex">
            <div class="fl-perguntas">

                <div class="fl-h1">
                    <h1 class="faq-titulo">Fale Conosco</h1>
                </div>

                <div class="fl-paragrafo">
                    <p class="fl-p">Preencha o formulario abaixo com suas dúvidas não respondidas em nosso FAQ, e
                        retornaremos ao seu e-mail o mais breve possível.
                    </p>

                </div>
            </div>

            <div class="fl-image">
                <img class="fl--cat" src="../../public/img/cat-resposta.png" alt="Foto do Gatinho">
            </div>
        </section>

        <section class="fl-dados">
            <form id="contactForm">
                <div class="fl-campos">
                    <label for="nome" class="inp-fl">Nome Completo
                        <p><input type="text" class="fl-inp" id="nome" placeholder="Digite seu nome" required
                                autocomplete="on"></p>
                    </label>
                </div>

                <div class="fl-campos">
                    <label for="email" class="inp-fl">Email
                        <p><input class="fl-inp" type="email" name="email" id="email" placeholder="Digite seu email"
                                required autocomplete="on">
                        </p>
                    </label>
                </div>

                <div class="fl-campos">
                    <label for="mensagem" class="inp-fl">Dúvida
                        <p><textarea class="fl-inp" id="mensagem" required placeholder="Digite aqui sua dúvida"
                                autocomplete="on"></textarea></p>
                    </label>
                </div>

                <div class="fl-button">
                    <button type="submit" class="fl-next">Enviar</button>
                </div>
            </form>
        </section>
    </main>

    <script src="../../public/js/scriptdaq.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>