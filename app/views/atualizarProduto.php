<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o funcionário está logado
$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (!$id_funcionario) {
    header('Location: Login.php');
    exit();
}

// --- PROCESSAMENTO DO FORMULÁRIO (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Dados básicos
        $id_produto = $_POST['id_produto'] ?? null;
        $modo = $_POST['modo'] ?? 'cadastro';
        $nome = trim($_POST['nome_produto']);
        $tipo = $_POST['tipo'];
        $marca = trim($_POST['marca']);
        $preco = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco']);
        $estoque = (int) $_POST['estoque'];
        $desc_curta = trim($_POST['descricao_curta']);
        $desc_detalhada = trim($_POST['descricao']);

        // Validações
        if (empty($nome) || empty($tipo) || empty($marca) || $preco <= 0) {
            throw new Exception("Preencha todos os campos obrigatórios!");
        }

        // --- TRATAMENTO DAS IMAGENS ---
        $imagensSalvas = [];
        $uploadDir = '../../public/uploads/produtos/';

        // 1. Imagens existentes (modo edição)
        if ($modo === 'edicao' && !empty($_POST['imagens_existentes'])) {
            $imagensRemovidas = json_decode($_POST['imagens_removidas'] ?? '[]', true);

            // Primeiro: excluir fisicamente as imagens removidas
            foreach ($imagensRemovidas as $imagemRemovida) {
                $caminhoCompleto = '../../public/' . $imagemRemovida;
                if (file_exists($caminhoCompleto)) {
                    unlink($caminhoCompleto); // Remove o arquivo fisicamente
                }
            }

            // Depois: manter apenas as não removidas
            foreach ($_POST['imagens_existentes'] as $imagem) {
                if (!in_array($imagem, $imagensRemovidas)) {
                    $imagensSalvas[] = $imagem;
                }
            }
        }

        // 2. Novas imagens
        if (!empty($_FILES['novas_imagens']['name'][0])) {
            foreach ($_FILES['novas_imagens']['tmp_name'] as $key => $tmpName) {
                $nomeArquivo = uniqid() . '_' . basename($_FILES['novas_imagens']['name'][$key]);
                $caminhoCompleto = $uploadDir . $nomeArquivo;

                if (move_uploaded_file($tmpName, $caminhoCompleto)) {
                    $imagensSalvas[] = 'uploads/produtos/' . $nomeArquivo;
                }
            }
        }

        // Valida se há pelo menos 1 imagem
        if (empty($imagensSalvas)) {
            throw new Exception("É necessário pelo menos uma imagem!");
        }

        // --- SALVAMENTO NO BANCO ---
        $conn->begin_transaction();

        try {
            // 1. Atualiza/Cadastra o produto
            if ($modo === 'edicao' && $id_produto) {
                $stmt = $conn->prepare("UPDATE produto SET 
                    nome_produto = ?, tipo = ?, marca = ?, valor = ?, quantidade = ?, 
                    descricaoMenor = ?, descricaoMaior = ? 
                    WHERE id_produto = ?");
                $stmt->bind_param("sssdissi", $nome, $tipo, $marca, $preco, $estoque, $desc_curta, $desc_detalhada, $id_produto);
            } else {
                $stmt = $conn->prepare("INSERT INTO produto 
                    (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $desc_curta, $desc_detalhada);
            }
            $stmt->execute();

            // Obtém ID do produto (se for cadastro)
            $id_produto = $modo === 'edicao' ? $id_produto : $conn->insert_id;

            // 2. Remove imagens antigas (modo edição)
            if ($modo === 'edicao') {
                $conn->query("DELETE FROM imagem_produto WHERE id_produto = $id_produto");
            }

            // 3. Insere as novas imagens
            foreach ($imagensSalvas as $imagem) {
                $conn->query("INSERT INTO imagem_produto (id_produto, nome_imagem) VALUES ($id_produto, '$imagem')");
            }

            $conn->commit();
            echo json_encode([
                'status' => 'success',
                'message' => 'Produto ' . ($modo === 'edicao' ? 'alterado' : 'cadastrado') . ' com sucesso!'
            ]);
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit();
    }
}

// --- CONTINUA COM O CÓDIGO ORIGINAL (GET) ---
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
                                <input type="hidden" name="imagens_removidas" id="imagens_removidas" value="[]">
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
    <script src="../../public/js/tema.js"></script>

    <script>
        // Variáveis globais
        let imagensSelecionadas = []; // Novas imagens selecionadas
        let imagensRemovidas = [];    // Imagens existentes removidas

        // Elementos DOM
        const inputPreco = document.getElementById('preco');
        const inputEstoque = document.getElementById('estoque');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('preview-container');
        const form = document.getElementById('formProduto');

        // Formatação do preço
        inputPreco.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value === '') {
                inputPreco.value = 'R$ 0,00';
                return;
            }
            value = (parseInt(value) / 100).toFixed(2);
            inputPreco.value = 'R$ ' + value.replace('.', ',');
        });

        // Validação do estoque
        inputEstoque.addEventListener('input', () => {
            inputEstoque.value = inputEstoque.value.replace(/\D/g, '').slice(0, 4);
        });

        // Remover imagem existente
        function removerImagemExistente(button) {
            const wrapper = button.parentElement;
            const imagemInput = wrapper.querySelector('input[name="imagens_existentes[]"]');

            if (imagemInput) {
                imagensRemovidas.push(imagemInput.value);
                document.getElementById('imagens_removidas').value = JSON.stringify(imagensRemovidas);
            }

            wrapper.remove();
        }

        // Remover nova imagem
        function removerNovaImagem(index) {
            imagensSelecionadas.splice(index, 1);
            atualizarPreview();
        }

        // Gerenciar novas imagens
        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            const tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

            const imagensExistentes = Array.from(document.querySelectorAll('input[name="imagens_existentes[]"]'))
                .filter(input => !imagensRemovidas.includes(input.value)).length;

            const slotsDisponiveis = 3 - (imagensExistentes - imagensRemovidas.length + imagensSelecionadas.length);

            if (files.length > slotsDisponiveis) {
                error(`Você só pode adicionar mais ${slotsDisponiveis} imagem(ns).`);
                fileInput.value = '';
                return;
            }

            files.forEach(file => {
                if (tiposPermitidos.includes(file.type)) {
                    imagensSelecionadas.push(file);
                } else {
                    error(`Tipo não suportado: ${file.name}`);
                }
            });

            atualizarPreview();
            fileInput.value = '';
        });

        // Atualizar visualização das imagens
        function atualizarPreview() {
            // Mantém as imagens existentes (não removidas)
            const existingWrappers = Array.from(previewContainer.querySelectorAll('.preview-wrapper'))
                .filter(wrapper => wrapper.querySelector('input[name="imagens_existentes[]"]'));

            previewContainer.innerHTML = '';

            // Reexibir as imagens existentes
            existingWrappers.forEach(wrapper => previewContainer.appendChild(wrapper));

            // Adicionar as novas imagens
            imagensSelecionadas.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-wrapper';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-img';

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = '×';
                    removeBtn.className = 'remove-btn';
                    removeBtn.onclick = () => removerNovaImagem(index);

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        // Contadores de caracteres
        document.addEventListener('DOMContentLoaded', function () {
            const descricaoCurta = document.getElementById('descricao-curta');
            const contadorCurta = document.getElementById('contador-curta');
            const descricaoDetalhada = document.getElementById('descricao-detalhada');
            const contadorDetalhada = document.getElementById('contador-detalhada');

            function atualizarContador(textarea, contador, max) {
                const caracteres = textarea.value.length;
                contador.textContent = caracteres;
                contador.style.color = caracteres >= max ? 'red' : '#666';
            }

            descricaoCurta.addEventListener('input', () =>
                atualizarContador(descricaoCurta, contadorCurta, 200));

            descricaoDetalhada.addEventListener('input', () =>
                atualizarContador(descricaoDetalhada, contadorDetalhada, 500));

            atualizarContador(descricaoCurta, contadorCurta, 200);
            atualizarContador(descricaoDetalhada, contadorDetalhada, 500);
        });

        // Validação do formulário
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Validação básica (imagens)
            const imagensExistentes = document.querySelectorAll('input[name="imagens_existentes[]"]').length;
            const totalImagens = imagensExistentes - imagensRemovidas.length + imagensSelecionadas.length;

            if (totalImagens === 0) {
                error("Pelo menos uma imagem é obrigatória.");
                return;
            }

            // Cria um FormData para enviar arquivos via AJAX
            const formData = new FormData(form);

            // Adiciona as novas imagens ao FormData
            imagensSelecionadas.forEach((file, index) => {
                formData.append('novas_imagens[]', file);
            });

            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    success(result.message);

                    // Redireciona após 3 segundos (opcional)
                    setTimeout(() => {
                        window.location.href = '../views/telaFuncionario.php';
                    }, 3000);
                } else {
                    error(result.message || "Erro ao salvar o produto.");
                }
            } catch (err) {
                error("Erro na requisição: " + err.message);
            }
        });
        // Função de notificação de erro
        function error(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #ff416c, #ff4b2b)",
                },
                stopOnFocus: true
            }).showToast();
        }

        // Função de notificação de sucesso
        function success(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                stopOnFocus: true
            }).showToast();
        }

    </script>
</body>

</html>