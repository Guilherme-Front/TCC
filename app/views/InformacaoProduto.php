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
                        <img class="user-img" src="../../public/img/engrenagem-do-usuario.png" alt="">
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

                    <div class="compra">
                        <button class="add-carrinho">
                            <img class="try-car" src="../../public/img/add-cart.png" alt="adicionar ao carrinho">
                        </button>

                        <a href="#"><button class="button-comprar" type="submit">Comprar</button></a>
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

            <div class="comentarios">

                <div class="comentario">
                    <div class="img-comentario">
                        <img src="../../public/img/gato.jpg" alt="foto-usuário">
                    </div>
                    <div class="txt-comentario">
                        <p id="tamanho-mobile">Nome</p>
                        <p>00/00/0000</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate molestias aut eum
                            dolore
                            corporis accusantium iusto dicta! Aliquam. Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Assumenda delectus ea dignissimos cupiditate quod natus quos eum earum
                            quas beatae, non, officiis praesentium nisi, aliquam cumque. Dicta, totam. Amet,
                            cupiditate?
                        </p>
                    </div>
                </div>

                <div class="comentario">
                    <div class="img-comentario">
                        <img src="../../public/img/gato.jpg" alt="foto-usuário">
                    </div>
                    <div class="txt-comentario">
                        <p id="tamanho-mobile">Nome</p>
                        <p>00/00/0000</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate molestias aut eum
                            dolore
                            corporis accusantium iusto dicta! Aliquam. Lorem ipsum dolor sit amet consectetur
                            adipisicing elit.</p>
                    </div>
                </div>
            </div>

        </section>

    </main>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/tema.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Função para adicionar produto ao carrinho com verificação de estoque
            document.querySelector('.add-carrinho')?.addEventListener('click', async function () {
                const idProduto = <?= $id_produto ?>;
                const nomeProduto = "<?= addslashes($produto['nome_produto']) ?>";
                const precoProduto = <?= $produto['valor'] ?>;
                const quantidade = parseInt(document.getElementById('quantidade').value);
                const imagemProduto = "<?= !empty($imagens) ? corrigirCaminhoImagem($imagens[0]['nome_imagem']) : '../../public/img/sem-imagem.png' ?>";
                const idCliente = <?= isset($_SESSION['id_cliente']) ? $_SESSION['id_cliente'] : 'null' ?>;

                if (!idCliente) {
                    error("Por favor, faça login para adicionar produtos ao carrinho.", "#e63946");
                    setTimeout(() => {
                        window.location.href = '../views/Login.php';
                    }, 3500);
                    return;
                }

                try {
                    // Verificar estoque antes de adicionar ao carrinho
                    const response = await fetch('../controllers/verificaEstoque.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_produto=${idProduto}&quantidade=${quantidade}`
                    });

                    const data = await response.json();

                    if (data.erro) {
                        error(data.erro, "linear-gradient(to right, #cd1809, #a01006)");
                        return;
                    }

                    if (!data.disponivel) {
                        error(`Quantidade indisponível em estoque. Máximo: ${data.estoque}`, "linear-gradient(to right, #cd1809, #a01006)");
                        return;
                    }

                    // Criar objeto do produto
                    const produto = {
                        id: idProduto,
                        nome: nomeProduto,
                        preco: precoProduto,
                        quantidade: quantidade,
                        imagem: imagemProduto,
                        estoque: data.estoque // Armazenamos o estoque atual para validações futuras
                    };

                    // Adicionar ao carrinho
                    adicionarAoCarrinho(produto, idCliente);

                } catch (err) {
                    console.error('Erro ao verificar estoque:', err);
                    error("Erro ao verificar disponibilidade do produto", "linear-gradient(to right, #cd1809, #a01006)");
                }
            });
        });

        function adicionarAoCarrinho(produto, idCliente) {
            const carrinhoKey = `carrinho_${idCliente}`;
            let carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

            // Verificar se o produto já está no carrinho
            const produtoExistenteIndex = carrinho.findIndex(item => item.id === produto.id);

            if (produtoExistenteIndex !== -1) {
                // Verificar se a nova quantidade ultrapassa o estoque
                const novaQuantidade = carrinho[produtoExistenteIndex].quantidade + produto.quantidade;

                if (novaQuantidade > produto.estoque) {
                    error(`Quantidade solicitada (${novaQuantidade}) excede o estoque disponível (${produto.estoque})`,
                        "linear-gradient(to right, #cd1809, #a01006)");
                    return;
                }

                carrinho[produtoExistenteIndex].quantidade = novaQuantidade;
            } else {
                carrinho.push(produto);
            }

            localStorage.setItem(carrinhoKey, JSON.stringify(carrinho));
            localStorage.removeItem(`carrinhoVazio_${idCliente}`);

            // Toast de sucesso e redirecionamento suave
            redirection("Produto adicionado ao carrinho com sucesso!", "../views/TelaCarrinho.php");
        }

        // Função existente para alterar quantidade
        function alterarQuantidade(valor) {
            let input = document.getElementById("quantidade");
            let quantidade = parseInt(input.value) + valor;
            if (quantidade >= 1) {
                input.value = quantidade;
            }
        }

        function redirection(message, target) {
            Toastify({
                text: message,
                close: true,
                gravity: "top", // `top` ou `bottom`
                position: "right", // `left`, `center` ou `right`
                stopOnFocus: true, // Impede o fechamento ao passar o mouse
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function () { } // Callback após clicar
            }).showToast();

            // Redireciona após o tempo do toast
            setTimeout(() => {
                window.location.href = target;
            }, 3500); // Tempo em milissegundos
        }

        function error(message, color) {
            Toastify({
                text: message,
                duration: 3500,
                close: true,
                gravity: "top", // `top` ou `bottom`
                position: "right", // `left`, `center` ou `right`
                stopOnFocus: true, // Impede o fechamento ao passar o mouse
                style: {
                    background: color,
                },
                onClick: function () { }
            }).showToast();
        }
    </script>
</body>

</html>