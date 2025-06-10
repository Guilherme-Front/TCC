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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <!-- Toastify CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <!-- Logo na aba do site  -->
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
</head>

<body class="fl-body">
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
      <form id="contactForm" action="../controllers/processaContato.php" method="POST">
        <div class="fl-campos">
          <label for="nome" class="inp-fl">Nome Completo
            <p><input type="text" class="fl-inp" id="nome" name="nome" placeholder="Digite seu nome" required
                autocomplete="on"></p>
          </label>
        </div>

        <div class="fl-campos">
          <label for="email" class="inp-fl">Email
            <p><input class="fl-inp" type="email" name="email" id="email" placeholder="Digite seu email" required
                autocomplete="on"></p>
          </label>
        </div>

        <div class="fl-campos">
          <label for="mensagem" class="inp-fl">Dúvida
            <p><textarea class="fl-inp" id="mensagem" name="mensagem" required placeholder="Digite aqui sua dúvida"
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
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Mostrar loader
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';

            // Coletar dados do formulário
            const formData = new FormData(this);

            // Enviar via AJAX
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Resetar botão
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                // Mostrar Toastify
                Toastify({
                    text: data.message,
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: data.success ? 
                            "linear-gradient(to right, #00b09b, #96c93d)" : 
                            "linear-gradient(to right, #cd1809, #a01006)",
                        borderRadius: "4px",
                        fontSize: "16px",
                        padding: "12px 24px"
                    }
                }).showToast();

                // Limpar formulário se sucesso
                if (data.success) {
                    contactForm.reset();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                Toastify({
                    text: "Erro na conexão. Tente novamente.",
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #cd1809, #a01006)",
                        borderRadius: "4px",
                        fontSize: "16px",
                        padding: "12px 24px"
                    }
                }).showToast();
            });
        });
    }

    <?php if (isset($_SESSION['toast'])): ?>
        Toastify({
            text: "<?php echo $_SESSION['toast']['message']; ?>",
            duration: 5000,
            close: true,
            gravity: "top",
            position: "right",
            style: {
                background: "<?php echo $_SESSION['toast']['type'] === 'success' ? 
                    'linear-gradient(to right, #00b09b, #96c93d)' : 
                    'linear-gradient(to right, #cd1809, #a01006)' ?>",
                borderRadius: "4px",
                fontSize: "16px",
                padding: "12px 24px"
            },
            stopOnFocus: true
        }).showToast();
        <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>
});
  </script>
</body>

</html>