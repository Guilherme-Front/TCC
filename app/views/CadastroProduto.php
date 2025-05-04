<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../../public/css/CadastroProduto.css">
    <!-- Logo na aba do site  -->
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

    <form action="../controllers/cadastroProduto.php" method="POST" enctype="multipart/form-data">
        <section>

            <div class="container-info">

                <div class="info">

                    <label>Nome do Produto</label>
                    <input type="text" name="nome_produto" id="" placeholder="Digite o nome do produto" class="txt">

                    <div class="upload-container"> 

                        <div class="container-img">
                            <label for="fileInput" class="upload-box">
                                <span class="spanC">Carregue até 3 imagens</span>
                            </label>
                            <input class="enviar-img" type="file" id="fileInput" multiple="multiple" accept="image/*"
                                name="produto_imagens[]" hidden>
                            <div id="preview-container" style="display: flex; gap: 5px;"></div>
                        </div>
                    </div>

                </div>

                <div class="info">

                    <label for="produto">Tipo</label>
                    <select class="opcao" id="produto" name="tipo">
                        <option class="select-txt" value="">Selecione o tipo...</option>
                        <option value="Rações">Rações</option>
                        <option value="Aperitivos">Aperitivos</option>
                        <option value="Coleiras">Coleiras</option>
                        <option value="Brinquedos">Brinquedos</option>
                        <option value="Higiene">Higiene</option>
                    </select>

                    <label>Marca</label>
                    <input type="text" name="marca" id="" placeholder="Digite a marca" class="txt">

                    <label>Preço</label>
                    <input aria-label="input" class="valor-input" type="text" name="preco" id="preco" min="1">

                    <label>Estoque</label>
                    <input class="valor-input" type="number" name="estoque" maxlength="3" id="estoque" placeholder="000">
                </div>

                <div class="info">

                    <label>Descrição curta</label>
                    <textarea class="txt" id="descricao" name="descricao_curta" rows="4"
                        placeholder="Digite a descrição do produto..."></textarea>

                    <label>Descrição detalhada</label>
                    <textarea class="txt" id="descricao_detalhada" name="descricao" rows="4"
                        placeholder="Digite a descrição do produto..."></textarea>

                    <div class="div-button">
                        <button class="cadastrar-button" type="submit" name="enviar-dados">Cadastrar</button>
                    </div>

                </div>
            </div>
        </section>
    </form>

    <script src="../../public/js/CadastroProduto.js"></script>
    <script src="../../public/js/tema.js"></script>
</body>

</html>