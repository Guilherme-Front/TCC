<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css">

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">


    <title>Login | Pet Insight</title>
</head>

<body class="login_dog">
    <?php if (isset($_SESSION['toast'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mantenha sua função error() original
                <?php if ($_SESSION['toast']['type'] === 'error'): ?>
                    error("<?= $_SESSION['toast']['message'] ?>", "linear-gradient(to right, #cd1809, #a01006)");
                <?php else: ?>
                    // Para mensagens de sucesso (que redirecionam)
                    redirection("<?= $_SESSION['toast']['message'] ?>", "../views/Index.php", "linear-gradient(to right, #00b09b, #96c93d)");
                <?php endif; ?>
            });
        </script>
        <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>

    <!-- Div para o SDK do Facebook -->
    <div id="fb-root"></div>

    <!-- Script para carregar o SDK do Facebook -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v18.0"
        nonce="YOUR_NONCE"></script>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '663378829642885', // Substitua pelo seu App ID do Facebook
                cookie: true, // Habilita o uso de cookies
                xfbml: true, // Habilita o processamento de tags XFBML
                version: 'v18.0' // Versão do SDK
            });
        };

        // Função para fazer login
        function login() {
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Usuário logado com sucesso:', response);
                } else {
                    console.log('Usuário cancelou o login.');
                }
            });
        }
    </script>

    <main>
        <section>
            <div class="login-content">
                <div class="login-border">
                    <a href="../views/Index.php"><i class="fi fi-ss-undo voltar" aria-label="nda"></i></a>

                    <h1 class="login-titulo">Faça Login</h1>

                    <form action="../controllers/Processalogin.php" method="POST">
                        <div class="login-input">
                            <label class="login-label" for="">E-mail</label>
                            <input class="input" type="email" name="email" id="email" placeholder="Digite seu e-mail"
                                required>

                            <label class="login-label" for="">Senha</label>
                            <input class="input" type="password" name="senha" id="Senha" placeholder="Digite sua senha"
                                required>
                        </div>

                        <div class="login-link">
                            <a href="../views/Redefinir.php" class="login-a">Esqueci minha senha</a>
                        </div>

                        <div class="login-botao">
                            <button name="submit" class="botao" type="submit">Entrar</button>
                        </div>

                        <div class="login-formas">
                            <p class="login-p">Não possui conta? <a href="../views/telaCadastro.php"
                                    class="login-cadastro">Cadastre-se</a></p>

                            <p class="login-resto">Ou</p>

                            <p class="login-conect">Conecte-se com</p>

                            <div class="login-images">

                                <button class="login-fb" onclick="login()"><img class="login-icon"
                                        src="../../public/img/facebook.png" alt="Imagem do Facebook"></button>
                                <img class="login-icon" src="../../public/img/google.png" alt="Imagem do Google">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            </div>
        </section>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="../../public/js/script.js"></script>
        <script src="../../public/js/tema.js"></script>

</body>

</html>