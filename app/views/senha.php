<?php 
session_start();

// Verifica se existem dados temporários de cadastro
if (!isset($_SESSION['cadastro_temp'])) {
    // Redireciona para a página de cadastro se não houver dados
    header("Location: cadastro.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Definir Senha | Pet Insight</title>
</head>

<body class="cadastro_cat">
    <section>
        <main>
            <div class="cadastro-content" id="senha-content">
                <div class="senha-border">
                    <h1 class="senha-titulo">Criar Senha</h1>

                    <form id="formSenha" method="POST">
                        <div class="senha-input">
                            <label class="cadastro-label" for="senha">Senha</label>
                            <input class="input" type="password" name="senha" id="pass" placeholder="Digite sua senha"
                                required minlength="6" maxlength="16">

                            <label class="cadastro-label" for="vSenha">Confirme sua Senha</label>
                            <input class="input" type="password" name="confirmar_senha" id="password"
                                placeholder="Digite novamente sua senha" required minlength="6" maxlength="16">
                        </div>

                        <div class="cadastro-botao">
                            <button class="botao-senha" type="submit">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </section>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Adiciona o evento de submit ao formulário de senha
        document.getElementById('formSenha').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const senha = document.getElementById('pass').value;
            const confirmar = document.getElementById('password').value;
            
            if (senha !== confirmar) {
                Toastify({
                    text: "As senhas não coincidem!",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #ff416c, #ff4b2b)",
                    }
                }).showToast();
                return;
            }
            
            // Envia os dados via AJAX
            fetch('../controllers/processaSenha.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 3000);
                } else {
                    Toastify({
                        text: data.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #ff416c, #ff4b2b)",
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>