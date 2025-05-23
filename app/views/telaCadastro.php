<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Imports pro Calendário -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/css/pikaday.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/pikaday.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">

    <title>Cadastro Pet Insight</title>
</head>

<body class="cadastro_cat">
    <section>
        <main>
            <div class="cadastro-content">
                <div class="cadastro-border">
                    <a href="../views/Index.php"><i class="fi fi-ss-undo cadastro-voltar"
                            aria-label="nda"></i></a>

                    <h1 class="cadastro-titulo">Cadastre-se</h1>

                    <!-- Formulário com método POST e ação para o script PHP -->
                    <form id="formCadastro" method="POST">
                        <div class="cadastro-input">
                            <label class="cadastro-label" for="Nome">Nome Completo <span
                                    class="cadastro-required">*</span></label>
                            <input class="input-cadastro" type="text" name="Nome" id="Nome"
                                placeholder="Digite seu nome completo" required>

                            <label class="cadastro-label" for="Email">E-mail <span
                                    class="cadastro-required">*</span></label>
                            <input class="input-cadastro" type="email" name="Email" id="Email"
                                placeholder="Digite seu e-mail" required>

                            <label class="cadastro-label" for="Telefone">Telefone <span
                                    class="cadastro-required">*</span></label>
                            <input class="input-cadastro" type="tel" name="Telefone" id="Telefone"
                                placeholder="(00) 00000-0000" maxlength="11" minlength="11" required>

                            <label class="cadastro-label" for="Data">Data de Nascimento <span
                                    class="cadastro-required">*</span></label>
                            <input class="input-cadastro" type="text" name="Data" id="Data" aria-label="data" required>
                        </div>

                        <div class="cadastro-botao">
                            <button class="botao-cadastro" type="submit">Cadastrar</button>
                        </div>

                        <div class="cadastro-formas">
                            <p class="cadastro-p">Já possui conta? <a href="../views/Login.php" class="login-cadastro">Faça
                                    Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </section>  

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../public/js/script.js"></script>
    <script src="../../public/js/tema.js"></script>

</body>

</html>