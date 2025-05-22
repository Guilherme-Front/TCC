<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/CadastroProduto.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">

    <title>Cadastro de Produtos | Pet Insight</title>
</head>

<body>
    <header>
        <a href="../views/Index.php">
            <img class="logo" src="../../public/img/Pet insight.png" alt="logo">
        </a>
    </header>

    <div class="voltar-index">
        <a href="../views/Index.php">
            <img class="botao-voltar" src="../../public/img/voltar.png" alt="botao-voltar" />
        </a>
        <h2 class="txt-cadastro">Cadastro de Produto</h2>
    </div>

    <form accept-charset="UTF-8" id="formProduto" method="POST" enctype="multipart/form-data">
        <section>
            <div class="container-info">
                <div class="info">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome_produto" placeholder="Digite o nome do produto" class="txt" maxlength="100" oninput="this.value = this.value.slice(0, 100)" required>

                    <div class="upload-container">
                        <div class="container-img">
                            <label for="fileInput" class="upload-box">
                                <span class="spanC">Carregue até 3 imagens</span>
                            </label>
                            <input class="enviar-img" type="file" id="fileInput" multiple accept="image/*" hidden >
                            <div id="preview-container"></div>
                        </div>
                    </div>
                </div>

                <div class="info">
                    <label for="produto">Tipo</label>
                    <select class="opcao" id="produto" name="tipo" required>
                        <option value="">Selecione o tipo...</option>
                        <option value="Rações">Rações</option>
                        <option value="Aperitivos">Aperitivos</option>
                        <option value="Coleiras">Coleiras</option>
                        <option value="Brinquedos">Brinquedos</option>
                        <option value="Higiene">Higiene</option>
                    </select>

                    <label>Marca</label>
                    <input type="text" name="marca" placeholder="Digite a marca" class="txt" maxlength="30" oninput="this.value = this.value.slice(0, 30)" required>

                    <label>Preço</label>
                    <input class="valor-input" type="text" name="preco" id="preco" placeholder="R$ 0,00" required>

                    <label>Estoque</label>
                    <input class="valor-input" type="number" name="estoque" id="estoque" placeholder="000" required>
                </div>

                <div class="info">
                    <label>Descrição curta</label>
                    <textarea class="txt" name="descricao_curta" rows="4" maxlength="200"
                        placeholder="Digite a descrição do produto..." id="descricao-curta" required></textarea>
                    <div class="contador-caracteres"><span id="contador-curta">0</span>/200</div>

                    <label>Descrição detalhada</label>
                    <textarea class="txt" name="descricao" rows="6" maxlength="500"
                        placeholder="Digite a descrição detalhada..." id="descricao-detalhada" required></textarea>
                    <div class="contador-caracteres"><span id="contador-detalhada">0</span>/500</div>

                    <div class="div-button">
                        <button class="cadastrar-button" type="submit" name="enviar-dados">Cadastrar</button>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../public/js/CadastroProduto.js?v=<?= time() ?>"></script>
    <script src="../../public/js/tema.js"></script>

</body>

</html>