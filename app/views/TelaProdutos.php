<?php
session_start();
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado
require_once '../controllers/conn.php';

// Verifica se há um filtro de categoria na URL
$categoria_filtro = $_GET['categoria'] ?? null;

// Modifica a query para filtrar por categoria se necessário
$sql = "SELECT p.*, 
               (SELECT nome_imagem 
                FROM imagem_produto 
                WHERE id_produto = p.id_produto 
                LIMIT 1) AS nome_imagem 
        FROM produto p";

// Se houver filtro de categoria, adiciona WHERE à query
if ($categoria_filtro && in_array($categoria_filtro, ['Rações', 'Aperitivos', 'Coleiras', 'Brinquedos', 'Higiene'])) {
  $sql .= " WHERE p.tipo = '" . $conn->real_escape_string($categoria_filtro) . "'";
}

$result = $conn->query($sql);
$produtos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Produtos | Pet Insight</title>


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet'
    href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
  <link rel="stylesheet" href="../../public/css/styleProdutos.css?v=<?= time() ?>">

  <!-- Logo na aba do site  -->
  <link rel="icon" type="image/x-icon" href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/TCC/public/img/favicon-32x32.png">
</head>

<body class="fl-body">
  <header class="header">
    <div class="header_container">
      <div class="header-titulo">
        <a href="../views/Index.php"><img class="header-img" src="../../public/img/Pet insight.png"
            alt="Imagem da Logo"></a>
      </div>

      <div class="search">
        <label for="search">
          <input type="search" class="TL-inp" name="search" id="search" placeholder="Pesquise aqui">
        </label>
      </div>

      <div class="header-link-tema">
        <?php if (isset($_SESSION['id_cliente'])): ?>
          <!-- Ícone de usuário e carrinho (usuário logado) -->
          <a class="header-link-none" href="../views/TelaPerfil.php">
            <img class="user-img" src="../../public/img/user.png" alt="">
          </a>

          <form method="post" action="../controllers/logout.php" style="display:inline;">
            <button type="submit" class="header-button-logout" aria-label="logout">Sair</button>
          </form>

          <a class="header-link-none" href="../views/TelaCarrinho.php">
            <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
          </a>


        <?php else: ?>
          <!-- Entrar, Cadastro e Carrinho (usuário não logado) -->
          <a class="header-entrar" href="../views/Login.html">Entrar |</a>
          <a class="header-cadastro" href="../views/telaCadastro.php">Cadastro</a>

          <a class="header-link-none" href="../views/Login.html">
            <i class="fi fi-ss-shopping-cart car" aria-label="car"></i>
          </a>
        <?php endif; ?>

        <button class="header-button" id="button-tema" type="submit" aria-label="tema">
          <img class="header-tema" src="../../public/img/tema.png" alt="Foto Mudança de Tema">
        </button>
      </div>

    </div>
  </header>

  <nav>
    <div class="nav_wrap">
      <a class="nav-link" href="../views/QuemSomos.php">Quem Somos</a>
      <a class="nav-link" href="../views/TelaProdutos.php">Produtos</a>
      <a class="nav-link" href="../views/Cuidados.php">Cuidados</a>
      <a class="nav-link" href="../views/CuriosidadesGeral.php">Curiosidades</a>
      <a class="nav-link" href="../views/Faq.php">Suporte</a>
    </div>
  </nav>

  <section class="TL_carrosel">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="../../public/img/foto-promoções.png" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="../../public/img/foto-adoção.png" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="../../public/img/foto-castração.png" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev"
        aria-label="sla">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next"
        aria-label="sla">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </a>
    </div>
  </section>

  <section class="categorias">

    <article class="categoria" data-tipo="Rações" onclick="filtrarProdutos('Rações')">
      <div class="circulo"><img src="../../public/img/pet-food (4).png" alt=""></div>
      <p class="tipo">Ração</p>
    </article>

    <article class="categoria" data-tipo="Aperitivos" onclick="filtrarProdutos('Aperitivos')">
      <div class="circulo"><img src="../../public/img/treats.png" alt=""></div>
      <p class="tipo">Aperitivos</p>
    </article>

    <article class="categoria" data-tipo="Coleiras" onclick="filtrarProdutos('Coleiras')">
      <div class="circulo"><img src="../../public/img/collar.png" alt=""></div>
      <p class="tipo">Coleiras</p>
    </article>

    <article class="categoria" data-tipo="Brinquedos" onclick="filtrarProdutos('Brinquedos')">
      <div class="circulo"><img src="../../public/img/dog-toy.png" alt=""></div>
      <p class="tipo">Brinquedos</p>
    </article>

    <article class="categoria" data-tipo="Higiene" onclick="filtrarProdutos('Higiene')">
      <div class="circulo"><img src="../../public/img/shampoo.png" alt=""></div>
      <p class="tipo">Higiene</p>
    </article>

  </section>

  <section class="produtos">
    <div class="grid-container">
      <?php foreach ($produtos as $produto):
        // Remove "uploads/imgProdutos/" se existir no nome da imagem
        $nome_imagem = str_replace('uploads/imgProdutos/', '', $produto['nome_imagem']);
        $caminho_imagem = "/TCC/public/uploads/imgProdutos/" . $nome_imagem;
        $caminho_absoluto = $_SERVER['DOCUMENT_ROOT'] . '/TCC/public/uploads/imgProdutos/' . $nome_imagem;
      ?>
        <article class="produto" data-categoria="<?= htmlspecialchars($produto['tipo']) ?>">
          <a href="InformacaoProduto.php?id=<?= $produto['id_produto'] ?>">
            <div class="img-produto">
              <?php if (file_exists($caminho_absoluto)): ?>
                <img src="<?= $caminho_imagem ?>" alt="<?= htmlspecialchars($produto['nome_produto']) ?>">
              <?php else: ?>
                <div class="imagem-padrao">
                  Imagem não encontrada:<br>
                  Nome: <?= htmlspecialchars($nome_imagem) ?><br>
                  Caminho: <?= htmlspecialchars($caminho_absoluto) ?>
                </div>
              <?php endif; ?>
            </div>
            <p><?= htmlspecialchars($produto['nome_produto']) ?></p>
            <p>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
</section>

  <script>
    function filtrarProdutos(categoria) {
      // Atualiza a URL sem recarregar a página
      window.history.pushState({}, '', `?categoria=${encodeURIComponent(categoria)}`);

      // Filtra os produtos no cliente (opcional - pode remover se preferir recarregar)
      const produtos = document.querySelectorAll('.produto');
      produtos.forEach(produto => {
        const produtoCategoria = produto.getAttribute('data-categoria');
        if (categoria === 'todos' || produtoCategoria === categoria) {
          produto.style.display = 'block';
        } else {
          produto.style.display = 'none';
        }
      });

      // Ou, para recarregar a página com o filtro (comente as linhas acima e descomente esta)
      // window.location.href = `?categoria=${encodeURIComponent(categoria)}`;
    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="../../public/js/TelaProdutos.js"></script> -->
  <script src="../../public/js/tema.js"></script>
</body>

</html>