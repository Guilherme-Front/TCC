<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o funcionário está logado
$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (!$id_funcionario) {
    header('Location: Login.php');
    exit();
}

// Verifica se está em modo de edição (tem ID na URL)
$modoEdicao = isset($_GET['id']);
$produto = null;
$imagensProduto = [];

if ($modoEdicao) {
    $id_produto = $_GET['id'];

    // Busca os dados do produto
    $stmt = $conn->prepare("SELECT * FROM produto WHERE id_produto = ?");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();

    // Busca as imagens do produto
    $stmt = $conn->prepare("SELECT nome_imagem FROM imagem_produto WHERE id_produto = ? ORDER BY id_imagens ASC");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $imagensProduto[] = $row['nome_imagem'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/CadastroProduto.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
    <title><?= $modoEdicao ? 'Editar Produto' : 'Cadastro de Produtos' ?> | Pet Insight</title>
</head>

<body>
    <header>
        <a href="../views/Index.php">
            <img class="logo" src="../../public/img/Pet insight.png" alt="logo">
        </a>
    </header>

    <div class="voltar-index">
        <a href="../views/telaFuncionario.php">
            <img class="botao-voltar" src="../../public/img/voltar.png" alt="botao-voltar" />
        </a>
        <h2 class="txt-cadastro"><?= $modoEdicao ? 'Editar Produto' : 'Cadastro de Produto' ?></h2>
    </div>

    <form accept-charset="UTF-8" id="formProduto" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_produto" value="<?= $modoEdicao ? $produto['id_produto'] : '' ?>">
        <input type="hidden" name="modo" value="<?= $modoEdicao ? 'edicao' : 'cadastro' ?>">

        <section>
            <div class="container-info">
                <div class="info">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome_produto" placeholder="Digite o nome do produto" class="txt"
                        maxlength="100" oninput="this.value = this.value.slice(0, 100)"
                        value="<?= $modoEdicao ? htmlspecialchars($produto['nome_produto']) : '' ?>" required>

                    <div class="upload-container">
                        <div class="container-img">
                            <label for="fileInput" class="upload-box">
                                <span class="spanC">Carregue até 3 imagens</span>
                            </label>
                            <input class="enviar-img" type="file" id="fileInput" multiple accept="image/*" hidden>
                            <div id="preview-container" class="preview-grid">
                                <?php if ($modoEdicao && !empty($imagensProduto)): ?>
                                    <?php foreach ($imagensProduto as $imagem): ?>
                                        <div class="preview-wrapper">
                                            <img src="../../public/<?= htmlspecialchars($imagem) ?>" alt="Imagem do produto"
                                                class="preview-img">
                                            <button type="button" class="remove-btn"
                                                onclick="removerImagemExistente(this)">×</button>
                                            <input type="hidden" name="imagens_existentes[]"
                                                value="<?= htmlspecialchars($imagem) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">
                    <label for="produto">Tipo</label>
                    <select class="opcao" id="produto" name="tipo" required>
                        <option value="">Selecione o tipo...</option>
                        <option value="Rações" <?= ($modoEdicao && $produto['tipo'] == 'Rações') ? 'selected' : '' ?>>
                            Rações</option>
                        <option value="Aperitivos" <?= ($modoEdicao && $produto['tipo'] == 'Aperitivos') ? 'selected' : '' ?>>Aperitivos</option>
                        <option value="Coleiras" <?= ($modoEdicao && $produto['tipo'] == 'Coleiras') ? 'selected' : '' ?>>
                            Coleiras</option>
                        <option value="Brinquedos" <?= ($modoEdicao && $produto['tipo'] == 'Brinquedos') ? 'selected' : '' ?>>Brinquedos</option>
                        <option value="Higiene" <?= ($modoEdicao && $produto['tipo'] == 'Higiene') ? 'selected' : '' ?>>
                            Higiene</option>
                    </select>

                    <label>Marca</label>
                    <input type="text" name="marca" placeholder="Digite a marca" class="txt" maxlength="30"
                        oninput="this.value = this.value.slice(0, 30)"
                        value="<?= $modoEdicao ? htmlspecialchars($produto['marca']) : '' ?>" required>

                    <label>Preço</label>
                    <input class="valor-input" type="text" name="preco" id="preco" placeholder="R$ 0,00"
                        value="<?= $modoEdicao ? number_format($produto['valor'], 2, ',', '.') : '' ?>" required>

                    <label>Estoque</label>
                    <input class="valor-input" type="number" name="estoque" id="estoque" placeholder="000"
                        value="<?= $modoEdicao ? $produto['quantidade'] : '' ?>" required>
                </div>

                <div class="info">
                    <label>Descrição curta</label>
                    <textarea class="txt" name="descricao_curta" rows="4" maxlength="200"
                        placeholder="Digite a descrição do produto..." id="descricao-curta"
                        required><?= $modoEdicao ? htmlspecialchars($produto['descricaoMenor'] ?? '') : '' ?></textarea>
                    <div class="contador-caracteres"><span
                            id="contador-curta"><?= $modoEdicao ? strlen($produto['descricaoMenor'] ?? '') : '0' ?></span>/200
                    </div>

                    <label>Descrição detalhada</label>
                    <textarea class="txt" name="descricao" rows="6" maxlength="500"
                        placeholder="Digite a descrição detalhada..." id="descricao-detalhada"
                        required><?= $modoEdicao ? htmlspecialchars($produto['descricaoMaior'] ?? '') : '' ?></textarea>
                    <div class="contador-caracteres"><span
                            id="contador-detalhada"><?= $modoEdicao ? strlen($produto['descricaoMaior'] ?? '') : '0' ?></span>/500
                    </div>

                    <div class="div-button">
                        <button class="cadastrar-button" type="submit" name="enviar-dados">
                            <?= $modoEdicao ? 'Salvar Alterações' : 'Cadastrar' ?>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../public/js/CadastroProduto.js?v=<?= time() ?>"></script>
    <script src="../../public/js/tema.js"></script>

    <script>
        // Array para armazenar imagens removidas
        let imagensRemovidas = [];

        // Função para remover imagens existentes
        function removerImagemExistente(button) {
            const wrapper = button.parentElement;
            const imagem = wrapper.querySelector('input[name="imagens_existentes[]"]').value;

            // Adiciona ao array de imagens removidas
            imagensRemovidas.push(imagem);
            document.getElementById('imagens_removidas').value = JSON.stringify(imagensRemovidas);

            // Remove a visualização
            wrapper.remove();
        }

        // Preview de novas imagens
        document.getElementById('fileInput').addEventListener('change', function (e) {
            const container = document.getElementById('preview-container');
            const files = e.target.files;

            // Limitar a 3 imagens
            if (files.length > 3) {
                alert('Por favor, selecione no máximo 3 imagens');
                this.value = '';
                return;
            }

            // Limpar previews de novas imagens (mantendo as existentes)
            const existingPreviews = container.querySelectorAll('.preview-wrapper');
            const newPreviews = Array.from(existingPreviews).filter(el => !el.querySelector('input[name="imagens_existentes[]"]'));
            newPreviews.forEach(el => el.remove());

            // Adicionar novas imagens
            for (let i = 0; i < Math.min(files.length, 3 - existingPreviews.length + newPreviews.length); i++) {
                const file = files[i];
                if (!file.type.match('image.*')) continue;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-wrapper';
                    wrapper.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="preview-img">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                <input type="hidden" name="novas_imagens[]">
            `;
                    container.appendChild(wrapper);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>