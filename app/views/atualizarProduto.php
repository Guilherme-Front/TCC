<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o funcionário está logado
$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (!$id_funcionario) {
    header('Location: Login.php');
    exit();
}

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

        if (empty($nome) || empty($tipo) || empty($marca) || $preco <= 0) {
            throw new Exception("Preencha todos os campos obrigatórios!");
        }

        $imagensSalvas = [];

        // Atualiza ou cadastra produto
        $conn->begin_transaction();

        try {
            if ($modo === 'edicao' && $id_produto) {
                $stmt = $conn->prepare("UPDATE produto SET 
                    nome_produto = ?, tipo = ?, marca = ?, valor = ?, quantidade = ?, 
                    descricaoMenor = ?, descricaoMaior = ? 
                    WHERE id_produto = ?");
                $stmt->bind_param("sssdissi", $nome, $tipo, $marca, $preco, $estoque, $desc_curta, $desc_detalhada, $id_produto);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("INSERT INTO produto 
                    (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $desc_curta, $desc_detalhada);
                $stmt->execute();
                $id_produto = $conn->insert_id;
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

        // Caminho da pasta específica do produto
        $uploadDir = __DIR__ . '/../../public/uploads/imgProdutos/' . $id_produto . '/';

        // Cria a pasta se não existir
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // 1. Imagens existentes (modo edição)
        if ($modo === 'edicao' && !empty($_POST['imagens_existentes'])) {
            $imagensRemovidas = json_decode($_POST['imagens_removidas'] ?? '[]', true);

            foreach ($imagensRemovidas as $imagemRemovida) {
                $caminhoCompleto = __DIR__ . '/../../public/' . ltrim($imagemRemovida, '/');
                if (file_exists($caminhoCompleto)) {
                    unlink($caminhoCompleto);
                }
            }

            foreach ($_POST['imagens_existentes'] as $imagem) {
                if (!in_array($imagem, $imagensRemovidas)) {
                    $imagensSalvas[] = $imagem;
                }
            }
        }

        // 2. Novas imagens
        if (!empty($_FILES['novas_imagens']['name'][0])) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            foreach ($_FILES['novas_imagens']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['novas_imagens']['error'][$key] !== UPLOAD_ERR_OK) {
                    throw new Exception("Erro no upload da imagem: " . $_FILES['novas_imagens']['name'][$key]);
                }

                if (!in_array($_FILES['novas_imagens']['type'][$key], $tiposPermitidos)) {
                    throw new Exception("Tipo de arquivo não suportado: " . $_FILES['novas_imagens']['name'][$key]);
                }

                if ($_FILES['novas_imagens']['size'][$key] > $maxFileSize) {
                    throw new Exception("Imagem muito grande (máx. 2MB): " . $_FILES['novas_imagens']['name'][$key]);
                }

                $extensao = pathinfo($_FILES['novas_imagens']['name'][$key], PATHINFO_EXTENSION);
                $nomeArquivo = 'prod_' . uniqid() . '.' . $extensao;
                $caminhoCompleto = $uploadDir . $nomeArquivo;

                if (move_uploaded_file($tmpName, $caminhoCompleto)) {
                    // Caminho relativo para o banco
                    $imagensSalvas[] = 'uploads/imgProdutos/' . $id_produto . '/' . $nomeArquivo;
                } else {
                    throw new Exception("Falha ao salvar a imagem: " . $_FILES['novas_imagens']['name'][$key]);
                }
            }
        }

        // Limite de 3 imagens por produto
        if (count($imagensSalvas) > 3) {
            throw new Exception("Máximo de 3 imagens permitidas por produto.");
        }

        if (empty($imagensSalvas)) {
            throw new Exception("É necessário pelo menos uma imagem!");
        }

        // Salvar imagens no banco
        $conn->begin_transaction();
        try {
            if ($modo === 'edicao') {
                $conn->query("DELETE FROM imagem_produto WHERE id_produto = $id_produto");
            }

            foreach ($imagensSalvas as $imagem) {
                $stmt = $conn->prepare("INSERT INTO imagem_produto (id_produto, nome_imagem) VALUES (?, ?)");
                $stmt->bind_param("is", $id_produto, $imagem);
                $stmt->execute();
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
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit();
    }
}

// --- Busca para edição ---
$modoEdicao = isset($_GET['id']);
$produto = null;
$imagensProduto = [];

if ($modoEdicao) {
    $id_produto = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM produto WHERE id_produto = ?");
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();

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
        let imagensSelecionadas = []; // Novas imagens selecionadas
        let imagensRemovidas = [];    // Imagens existentes removidas

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

            const totalImagensAtuais = imagensExistentes + imagensSelecionadas.length;
            const slotsDisponiveis = 3 - totalImagensAtuais;

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
            const existingWrappers = Array.from(previewContainer.querySelectorAll('.preview-wrapper'))
                .filter(wrapper => {
                    const input = wrapper.querySelector('input[name="imagens_existentes[]"]');
                    return input && !imagensRemovidas.includes(input.value);
                });

            previewContainer.innerHTML = '';

            existingWrappers.forEach(wrapper => previewContainer.appendChild(wrapper));

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

            const imagensExistentes = Array.from(document.querySelectorAll('input[name="imagens_existentes[]"]'))
                .filter(input => !imagensRemovidas.includes(input.value)).length;

            const totalImagens = imagensExistentes + imagensSelecionadas.length;

            if (totalImagens === 0) {
                error("Pelo menos uma imagem é obrigatória.");
                return;
            }

            const formData = new FormData(form);

            imagensSelecionadas.forEach((file) => {
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