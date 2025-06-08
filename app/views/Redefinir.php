<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS do Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="stylesheet" href="../../public/css/style.css?v=<?= time() ?>">
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
    <title>Redefinir Senha | Pet Insight</title>

    <style>
        /* Fallback para quando Toastify não carregar */
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            color: white;
            border-radius: 5px;
            z-index: 9999;
            max-width: 300px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .custom-toast.success {
            background: linear-gradient(to right, #00b09b, #96c93d);
        }

        .custom-toast.error {
            background: linear-gradient(to right, #cd1809, #a01006);
        }
    </style>
</head>

<body class="cadastro_cat">
    <section>
        <div class="cadastro-content" id="redefinir-content">
            <div class="redefinir-border">
                <h1 class="senha-titulo" id="redefinir-titulo">Redefinir Senha</h1>

                <form id="formRedefinir" class="form-senha" method="POST">
                    <div class="senha-input">
                        <label class="cadastro-label" id="Emailsenha" for="EmailSenha">E-mail</label>
                        <input class="input" type="email" name="email" id="EmailSenha" placeholder="Digite seu e-mail" required>
                        <span class="senha-span">É necessário para identificar sua conta</span>

                        <div id="codigoContainer" style="display: none;">
                            <label class="cadastro-label" for="codigoVerificacao">Código de Verificação</label>
                            <input class="input" type="text" name="codigo" id="codigoVerificacao" placeholder="Digite o código recebido" required>

                            <label class="cadastro-label" for="novaSenha">Nova Senha</label>
                            <input class="input" type="password" name="novaSenha" id="novaSenha" placeholder="Digite sua nova senha" required>

                            <label class="cadastro-label" for="confirmarSenha">Confirmar Senha</label>
                            <input class="input" type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirme sua nova senha" required>
                        </div>
                    </div>

                    <div class="cadastro-botao">
                        <button type="button" id="btnEnviarCodigo" class="botao-redefinir">Enviar Código</button>
                        <button type="button" id="btnRedefinirSenha" class="botao-redefinir" style="display: none;">Redefinir Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- JavaScript Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0"></script>

    <script>
        // Sistema de toast robusto com fallback
        function showToast(message, isSuccess) {
            console.log('Exibindo toast:', message, isSuccess); // Log para debug

            // Tenta usar Toastify se estiver disponível
            if (typeof Toastify !== 'undefined') {
                try {
                    new Toastify({
                        text: message,
                        duration: 3500,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: isSuccess ?
                            "linear-gradient(to right, #00b09b, #96c93d)" :
                            "linear-gradient(to right, #cd1809, #a01006)",
                        stopOnFocus: true
                    }).showToast();
                } catch (e) {
                    console.error('Erro no Toastify:', e);
                    showFallbackToast(message, isSuccess);
                }
            } else {
                showFallbackToast(message, isSuccess);
            }
        }

        // Fallback para toast
        function showFallbackToast(message, isSuccess) {
            const toast = document.createElement('div');
            toast.className = `custom-toast ${isSuccess ? 'success' : 'error'}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3500);
        }

        // Funções específicas
        function success(message) {
            showToast(message, true);
        }

        function error(message) {
            showToast(message, false);
        }

        function redirection(message, target, delay = 2000) {
            success(message);
            setTimeout(() => {
                window.location.href = target;
            }, delay);
        }

        // Eventos após o carregamento da página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM completamente carregado'); // Log para debug
            

            // Botão Enviar Código
            document.getElementById('btnEnviarCodigo').addEventListener('click', function(e) {
                e.preventDefault();
                const email = document.getElementById('EmailSenha').value.trim();

                if (!email) {
                    error("Digite seu e-mail para receber o código.");
                    return;
                }

                // Mostrar loading no botão
                const btn = this;
                const originalText = btn.textContent;
                btn.disabled = true;
                btn.textContent = "Enviando...";

                fetch('../controllers/processaRedefinirSenha.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            email: email,
                            enviar_codigo: '1'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erro na rede');
                        return response.json();
                    })
                    .then(data => {
                        console.log('Resposta do servidor:', data); // Log para debug
                        if (data.success) {
                            success(data.message);
                            document.getElementById('codigoContainer').style.display = 'block';
                            document.getElementById('btnEnviarCodigo').style.display = 'none';
                            document.getElementById('btnRedefinirSenha').style.display = 'block';
                        } else {
                            error(data.message);
                        }
                    })
                    .catch(err => {
                        console.error('Erro:', err);
                        error("Erro ao enviar o código. Por favor, tente novamente.");
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.textContent = originalText;
                    });
            });

            // Botão Redefinir Senha
            document.getElementById('btnRedefinirSenha').addEventListener('click', function(e) {
                e.preventDefault();
                const form = document.getElementById('formRedefinir');
                const formData = new FormData(form);

                // Adiciona o parâmetro redefinir_senha
                formData.append('redefinir_senha', '1');

                // Validação básica no cliente
                const novaSenha = formData.get('novaSenha');
                const confirmarSenha = formData.get('confirmarSenha');

                if (novaSenha !== confirmarSenha) {
                    error("As senhas não coincidem!");
                    return;
                }

                if (novaSenha.length < 8) {
                    error("A senha deve ter no mínimo 8 caracteres!");
                    return;
                }

                // Mostrar loading no botão
                const btn = this;
                const originalText = btn.textContent;
                btn.disabled = true;
                btn.textContent = "Processando...";

                fetch('../controllers/processaRedefinirSenha.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erro na rede');
                        return response.json();
                    })
                    .then(data => {
                        console.log('Resposta de redefinição:', data); // Log para debug
                        if (data.success) {
                            redirection(data.message, '../views/login.php?sucesso=1');
                        } else {
                            error(data.message);
                        }
                    })
                    .catch(err => {
                        console.error('Erro:', err);
                        error("Erro ao redefinir senha. Por favor, tente novamente.");
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.textContent = originalText;
                    });
            });
        });
    </script>
</body>

</html>