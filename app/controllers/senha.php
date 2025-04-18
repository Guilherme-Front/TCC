<?php 
session_start();

// Verifica se o cadastro foi concluído
if (!isset($_SESSION['cadastro_concluido']) || $_SESSION['cadastro_concluido'] !== true) {
    // Redireciona para a página de cadastro se o cadastro não foi concluído
    header("Location: ../views/Index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Definir Senha | Pet Insight</title>
</head>

<body class="cadastro_cat">
    <section>
        <main>
            <div class="cadastro-content" id="senha-content">
                <div class="senha-border">
                    <h1 class="senha-titulo">Criar Senha</h1>

                    <!-- Formulário para enviar a senha -->
                    <form action="../controllers/processaSenha.php" method="POST">
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
</body>

</html>
