<?php
session_start();
require_once '../controllers/conn.php'; // Ajuste o caminho conforme sua estrutura

if (!isset($_GET['id'])) {
    header('Location: TelaProdutos.php');
    exit();
}

$id_produto = $_GET['id'];

// Buscar informações do produto
$sql_produto = "SELECT * FROM produto WHERE id_produto = ?";
$stmt = $conn->prepare($sql_produto);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();

if (!$produto) {
    header('Location: TelaProdutos.php');
    exit();
}

// Buscar imagens do produto
$sql_imagens = "SELECT nome_imagem FROM imagem_produto WHERE id_produto = ?";
$stmt = $conn->prepare($sql_imagens);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$imagens = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Função para corrigir o caminho da imagem
function corrigirCaminhoImagem($nome_imagem)
{
    // Remove qualquer ocorrência de "uploads/imgProdutos/" no nome da imagem
    $nome_corrigido = str_replace('uploads/imgProdutos/', '', $nome_imagem);
    $nome_corrigido = str_replace('uploads\\imgProdutos\\', '', $nome_corrigido); // Para caminhos com barras invertidas

    // Retorna o caminho correto
    return '/TCC/public/uploads/imgProdutos/' . $nome_corrigido;
}

// Buscar comentários do produto
$sql_comentarios = "SELECT c.*, nome, foto
                    FROM comentarios c
                    JOIN cliente cl ON c.id_cliente = cl.id_cliente
                    WHERE c.id_produto = ?
                    ORDER BY c.data_comentario DESC";
$stmt = $conn->prepare($sql_comentarios);
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$comentarios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Processar envio de novo comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario']) && isset($_SESSION['id_cliente'])) {
    $comentario = trim($_POST['comentario']);
    $id_cliente = $_SESSION['id_cliente'];

    // Validação adicional
    if (!empty($comentario) && strlen($comentario) <= 500) { // Limite de 500 caracteres
        $comentario = htmlspecialchars($comentario, ENT_QUOTES, 'UTF-8');

        $sql_insert = "INSERT INTO comentarios (id_produto, id_cliente, comentario, data_comentario) 
                      VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql_insert);

        if ($stmt) {
            $stmt->bind_param("iis", $id_produto, $id_cliente, $comentario);

            if ($stmt->execute()) {
                // Recarrega os comentários após inserção
                $stmt = $conn->prepare($sql_comentarios);
                if ($stmt) {
                    $stmt->bind_param("i", $id_produto);
                    $stmt->execute();
                    $comentarios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                    // Mensagem de sucesso
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                }
            } else {
                error_log("Erro ao executar query: " . $stmt->error);
            }
        } else {
            error_log("Erro ao preparar query: " . $conn->error);
        }
    }
}

// Processar exclusão de comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_comentario'])) {
    $id_comentario = $_POST['excluir_comentario'];

    // Verificar se o usuário tem permissão para excluir
    $sql_verificar = "SELECT id_cliente FROM comentarios WHERE id_comentario = ?";
    $stmt = $conn->prepare($sql_verificar);
    $stmt->bind_param("i", $id_comentario);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();

    if ($resultado) {
        // Permite exclusão se for o autor ou um administrador
        if (isset($_SESSION['id_funcionario']) || (isset($_SESSION['id_cliente']) && $_SESSION['id_cliente'] == $resultado['id_cliente'])) {
            $sql_excluir = "DELETE FROM comentarios WHERE id_comentario = ?";
            $stmt = $conn->prepare($sql_excluir);
            $stmt->bind_param("i", $id_comentario);

            if ($stmt->execute()) {
                // Recarregar a página após exclusão
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../../public/css/produto.css?v=<?= time() ?>">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>

    <!-- Logo na aba do site  -->
    <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">

    <title>Informações do Produto | Pet Insight</title>
</head>

<body>
    <header class="header">
        <div class="header_container">
            <div class="header-titulo">
                <a href="../views/Index.php"><img class="header-img" src="../../public/img/Pet insight.png"
                        alt="Imagem da Logo"></a>
            </div>

            <div class="header-link-tema">
                <?php if (isset($_SESSION['id_funcionario'])): ?>

                    <a class="header-link-none" href="../views/telaFuncionario.php">
                        <img class="user-imgF" src="../../public/img/administrador.png" alt="">
                    </a>

                <?php elseif (isset($_SESSION['id_cliente'])): ?>
                    <!-- Cliente logado - Mostrar perfil e carrinho -->
                    <a class="header-link-none" href="../views/TelaPerfil.php">
                        <img class="user-img" src="../../public/img/user.png" alt="">
                    </a>

                    <a class="header-link-none" href="../views/telaCarrinho.php">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>

                <?php else: ?>
                    <!-- Usuário não logado - Mostrar opções de login/cadastro -->
                    <a class="header-entrar" href="../views/Login.php">Entrar |</a>
                    <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

                    <a class="header-link-none" href="../views/TelaCarrinho.php">
                        <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
                    </a>
                <?php endif; ?>

                <button class="header-button" id="button-tema" type="submit" aria-label="tema">
                    <img class="header-tema" src="../../public/img/tema.png" alt="Foto Mudança de Tema">
                </button>
            </div>
        </div>
    </header>
    <main class="mainInfo">

        <div class="voltar">
            <a href="../views/TelaProdutos.php">
                <img class="botao-voltar" src="../../public/img/voltar.png" alt="botao-voltar" />
            </a>
        </div>
        <section class="Produto">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($imagens as $index => $imagem): ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index ?>"
                            <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>
                            aria-label="Slide <?= $index + 1 ?>"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner">
                    <?php foreach ($imagens as $index => $imagem):
                        $caminho_imagem = corrigirCaminhoImagem($imagem['nome_imagem']);
                        $caminho_absoluto = $_SERVER['DOCUMENT_ROOT'] . $caminho_imagem;
                    ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <?php if (file_exists($caminho_absoluto)): ?>
                                <img src="<?= $caminho_imagem ?>" class="d-block w-100"
                                    alt="<?= htmlspecialchars($produto['nome_produto']) ?>">
                            <?php else: ?>
                                <div class="imagem-padrao">
                                    Imagem não encontrada:<br>
                                    <?= htmlspecialchars($imagem['nome_imagem']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            <div class="informacoes-produto">
                <div class="info">
                    <h2><?= $produto['nome_produto'] ?></h2>
                    <p class="preço">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
                    <p class="p-information" id="p-informacao"><?= $produto['descricaoMenor'] ?></p>

                    <div class="compra-qtde">
                        <label class="qtde-label" for="quantidade">Quantidade</label>
                        <button class="button-add" onclick="alterarQuantidade(-1)">−</button>
                        <input class="input-add" disabled type="text" id="quantidade" value="1" readonly>
                        <button class="button-add2" onclick="alterarQuantidade(1)">+</button>
                    </div>

                    <!-- No seu HTML, modifique a seção do botão de comprar -->
                    <div class="compra">
                        <?php if (isset($_SESSION['id_funcionario'])): ?>
                            <!-- Botão para funcionários (só mostra mensagem) -->
                            <button class="add-carrinho" onclick="mostrarMensagemFuncionario()">
                                <img class="try-car" src="../../public/img/add-cart.png" alt="adicionar ao carrinho">
                            </button>
                            <button class="button-comprar" onclick="mostrarMensagemFuncionario()">Comprar</button>

                        <?php elseif (isset($_SESSION['id_cliente'])): ?>
                            <!-- Botão para clientes logados (funcional) -->
                            <button class="add-carrinho" id="btn-add-carrinho" onclick="adicionarAoCarrinho()">
                                <img class="try-car" src="../../public/img/add-cart.png" alt="adicionar ao carrinho">
                            </button>
                            <button class="button-comprar" onclick="comprarAgora()">Comprar</button>

                        <?php else: ?>
                            <!-- Botão para visitantes (redireciona para login) -->
                            <button class="add-carrinho" onclick="redirecionarParaLogin()">
                                <img class="try-car" src="../../public/img/add-cart.png" alt="adicionar ao carrinho">
                            </button>
                            <button class="button-comprar" onclick="redirecionarParaLogin()">Comprar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="descricao-container">
            <div class="txt-descricao">
                <h2>Descrição</h2>
            </div>
            <div class="descricao">
                <div class="sobre">
                    <p><?= $produto['descricaoMaior'] ?></p>
                </div>
            </div>
        </section>


        <section class="avaliaçâo">
            <div class="txt-avaliação">
                <h2>Avaliações</h2>
            </div>

            <?php if (isset($_SESSION['id_cliente'])): ?>
                <div class="adicionar-comentario">
                    <form method="POST" action="">
                        <textarea name="comentario" placeholder="Deixe seu comentário sobre o produto..."
                            required></textarea>
                        <button type="submit" class="btn-enviar-comentario">Enviar Comentário</button>
                    </form>
                </div>
            <?php elseif (!isset($_SESSION['id_funcionario'])): ?>
                <div class="aviso-login">
                    <p>Faça <a href="../views/Login.php">login</a> para deixar um comentário.</p>
                </div>
            <?php endif; ?>

            <div class="comentarios">
                <?php if (!empty($comentarios)): ?>
                    <?php foreach ($comentarios as $comentario): ?>
                        <div class="comentario">
                            <div class="img-comentario">
                                <?php
                                if (!empty($comentario['foto'])) {
                                    $nomeArquivo = basename($comentario['foto']);
                                    $caminhoRelativo = "/TCC/public/uploads/imgUsuarios/{$comentario['id_cliente']}/{$nomeArquivo}";
                                    $caminhoAbsoluto = $_SERVER['DOCUMENT_ROOT'] . $caminhoRelativo;

                                    if (file_exists($caminhoAbsoluto)) {
                                        $foto = $caminhoRelativo;
                                    } else {
                                        $foto = '../../public/img/user-default.png';
                                    }
                                } else {
                                    $foto = '../../public/img/user-default.png';
                                }
                                ?>
                                <img src="<?= htmlspecialchars($foto) ?>" alt="foto-usuário"
                                    onerror="this.src='../../public/img/user-default.png'">
                            </div>

                            <div class="txt-comentario">
                                <div class="cabecalho-comentario">
                                    <div>
                                        <p class="nome-usuario"><?= htmlspecialchars($comentario['nome']) ?></p>
                                        <p class="data-comentario">
                                            <?= date('d/m/Y H:i', strtotime($comentario['data_comentario'])) ?></p>
                                    </div>
                                    <?php if (isset($_SESSION['id_cliente']) && $_SESSION['id_cliente'] == $comentario['id_cliente'] || isset($_SESSION['id_funcionario'])): ?>
                                        <form method="POST" class="form-excluir-comentario">
                                            <input type="hidden" name="excluir_comentario"
                                                value="<?= $comentario['id_comentario'] ?>">
                                            <button type="submit" class="btn-excluir-comentario"
                                                data-comentario-id="<?= $comentario['id_comentario'] ?>">
                                                <i class="fi fi-ss-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <p class="texto-comentario"><?= nl2br(htmlspecialchars($comentario['comentario'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="sem-comentarios">
                        <p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/tema.js"></script>

    <script>
        // Função para mostrar mensagem para funcionários
        function mostrarMensagemFuncionario() {
            Toastify({
                text: "Funcionários não podem realizar compras.",
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)"
                }
            }).showToast();
        }

        // Função para redirecionar usuários não logados
        function redirecionarParaLogin() {
            Toastify({
                text: "Por favor, faça login para continuar.",
                duration: 3000,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                }
            }).showToast();

            setTimeout(() => {
                window.location.href = '../views/Login.php?redirect=' + encodeURIComponent(window.location.pathname);
            }, 3500);
        }

        // Função principal para adicionar ao carrinho
        async function adicionarAoCarrinho() {
            const btn = document.getElementById('btn-add-carrinho');

            // btn.disabled = true;
            // btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...';

            try {
                const idProduto = <?= $id_produto ?>;
                const quantidade = document.getElementById('quantidade').value;

                const response = await fetch('../controllers/adicionarCarrinho.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id_produto=${idProduto}&quantidade=${quantidade}`
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Erro no servidor');
                }

                if (result.success) {
                    // Adicionar ao localStorage
                    const carrinhoKey = `carrinho_${<?= $_SESSION['id_cliente'] ?? 0 ?>}`;
                    let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

                    // Verificar se o produto já está no carrinho
                    const index = carrinho.findIndex(item => item.id === result.produto.id);

                    if (index !== -1) {
                        // Atualizar quantidade se já existir
                        carrinho[index].quantidade += parseInt(quantidade);
                    } else {
                        // Adicionar novo item
                        carrinho.push(result.produto);
                    }

                    localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));

                    Toastify({
                        text: result.message || "Produto adicionado ao carrinho!",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)"
                        }
                    }).showToast();

                    // Atualizar contador do carrinho se existir
                    if (typeof atualizarContadorCarrinho === 'function') {
                        atualizarContadorCarrinho();
                    }
                } else {
                    Toastify({
                        text: result.message || "Erro ao adicionar ao carrinho",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)"
                        }
                    }).showToast();
                }
            } catch (error) {
                console.error("Erro:", error);
                Toastify({
                    text: error.message || "Erro ao processar sua solicitação",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #ff5f6d, #ffc371)"
                    }
                }).showToast();
            } finally {
                btn.disabled = false;
            }
        }

        // Função para compra direta
        async function comprarAgora() {
            const btn = document.getElementById('btn-comprar');
            btn.disabled = true;
            btn.textContent = 'Processando...';

            try {
                await adicionarAoCarrinho();
                window.location.href = '../views/telaCarrinho.php?checkout=true';
            } catch (error) {
                console.error("Erro na compra:", error);
            } finally {
                btn.disabled = false;
                btn.textContent = 'Comprar';
            }
        }

        // Função para confirmar e excluir comentário
        document.querySelectorAll('.btn-excluir-comentario').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const comentarioId = this.getAttribute('data-comentario-id');
                const form = this.closest('form');

                // Criar elemento div para conter a mensagem e os botões
                const toastContent = document.createElement('div');
                toastContent.innerHTML = `
            <div>Deseja realmente excluir este comentário?</div>
            <div class="toastify-buttons-container">
                <button class="toastify-button toastify-confirm">Sim</button>
                <button class="toastify-button toastify-cancel">Não</button>
            </div>
        `;

                // Criar o Toastify
                const toast = Toastify({
                    node: toastContent,
                    duration: -1, // -1 means the toast won't auto-close
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, white, white)", // Fixed gradient syntax
                        padding: '15px',
                        width: '300px',
                        border: '1px solid grey',
                        color: 'black'
                    },
                    onClick: function() {} // Prevents closing when clicked
                });

                // Show the toast
                toast.showToast();

                // Adicionar eventos aos botões
                const toastElement = toast.toastElement;
                toastElement.querySelector('.toastify-confirm').addEventListener('click', function() {
                    if (form) {
                        form.submit();
                    }
                    toast.hideToast();
                });

                toastElement.querySelector('.toastify-cancel').addEventListener('click', function() {
                    toast.hideToast();
                });
            });
        });
    </script>
</body>

</html>