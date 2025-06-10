<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o funcionário está logado
$id_funcionario = $_SESSION['id_funcionario'] ?? null;

if (!$id_funcionario) {
  header('Location: Login.php');
  exit();
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Busca os dados do funcionário
$stmt = $conn->prepare("SELECT nome, email, senha, telefone, datNasc, foto FROM funcionario WHERE id_funcionario = ?");
$stmt->bind_param("i", $id_funcionario);
$stmt->execute();
$result = $stmt->get_result();
$funcionario = $result->fetch_assoc();

// Formata a data de nascimento
$dataNascFormatada = '';
if (!empty($funcionario['datNasc']) && $funcionario['datNasc'] !== '0000-00-00') {
  $data = DateTime::createFromFormat('Y-m-d', $funcionario['datNasc']);
  if ($data) {
    $dataNascFormatada = $data->format('d/m/Y');
  }
}

// Busca todos os produtos cadastrados no banco com a primeira imagem de cada produto
$produtos = [];
$sql = "
SELECT p.id_produto, p.nome_produto, p.quantidade, p.marca, p.valor, p.tipo,
       (SELECT ip.nome_imagem 
        FROM imagem_produto ip 
        WHERE ip.id_produto = p.id_produto 
        ORDER BY ip.id_imagens ASC LIMIT 1) AS nome_imagem
FROM produto p
";

// Verifica se há filtro por categoria na URL
$categoria_filtro = $_GET['categoria'] ?? 'Todos';

// Adiciona filtro se não for 'Todos'
if ($categoria_filtro !== 'Todos') {
  $sql .= " WHERE p.tipo = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $categoria_filtro);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query($sql);
}

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $produtos[] = $row;
  }
} else {
  echo "Erro na consulta dos produtos: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="../../public/css/perfil.css?v=<?= time() ?>">
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
  <title>Tela de Perfil | Pet Insight</title>
</head>

<body>
  <?php if (isset($_SESSION['toast'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Toastify({
          text: "<?= $_SESSION['toast']['message'] ?>",
          duration: 3500,
          close: true,
          gravity: "top",
          position: "right",
          stopOnFocus: true,
          style: {
            background: "<?= $_SESSION['toast']['type'] === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)' ?>",
            borderRadius: "4px",
            boxShadow: "0 4px 8px rgba(0,0,0,0.1)",
            fontSize: "14px"
          },
          onClick: function () { }
        }).showToast();
      });
    </script>
    <?php unset($_SESSION['toast']); ?>
  <?php endif; ?>

  <header>
    <a href="../views/Index.php">
      <img class="logo" src="../../public/img/Pet insight.png" alt="logo">
    </a>
  </header>

  <div class="voltarP">
    <a href="../views/Index.php">
      <img class="botao-voltar" src="../../public/img/voltar.png" alt="botão voltar" />
    </a>
    <h2 class="minha-conta">Minha conta</h2>
  </div>

  <main>
    <aside>
      <nav class="menu-lateral-fn">
        <ul>
          <li class="item-menu ativo" data-section="perfil-section">
            <a href="#perfil-section">
              <span class="icon"><img class="icons-img" src="../../public/img/file-user.png" alt="usuário"></span>
              <span class="txt-link">Meus dados</span>
            </a>
          </li>

          <li class="item-menu" data-section="produtos-cadastrados">
            <a href="#produtos-cadastrados">
              <span class="icon"><img class="icons-img" src="../../public/img/product.png" alt="produtos"></span>
              <span class="txt-link">Produtos cadastrados</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="../views/CadastroProduto.php">
              <span class="icon"><img class="icons-img" src="../../public/img/add-product (2).png"
                  alt="cadastrar-produto"></span>
              <span class="txt-link">Cadastrar produtos</span>
            </a>
          </li>

          <li class="item-menu-logoff">
            <a href="../controllers/logout.php">
              <span class="icon"><img class="icons-img" src="../../public/img/exit.png" alt="sair"></span>
              <span class="txt-logoff">Sair da conta</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <section>
      <!-- Seção de Perfil -->
      <div class="perfil-section" id="perfil-section">
        <form action="../controllers/FuncionarioController.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
          <div class="img-txt">
            <div class="foto-container">
              <?php if (!empty($funcionario['foto'])): ?>
                <img class="gato" id="previewFoto"
                  src="../../public/uploads/imgUsuarios/<?= $id_funcionario . '/' . htmlspecialchars($funcionario['foto'] ?? '') ?>"
                  alt="Foto do perfil" />
              <?php else: ?>
                <img src="../../public/img/user-img.png" class="gato" id="previewFoto" alt="Foto do perfil" />
              <?php endif; ?>

              <p class="boas-vindas">Olá
                <strong><?= htmlspecialchars($funcionario['nome'] ?? 'Funcionário') ?>!</strong>
              </p>
            </div>

            <div class="flex-enviar">
              <input type="file" name="foto" id="foto" class="enviar-foto" hidden>
              <label for="foto" class="enviar-foto" id="btn-enviar-foto" style="display: none;">Enviar foto</label>
            </div>
          </div>

          <div class="dados-pessoais">
            <div class="dados">
              <label for="nome">Nome completo</label>
              <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($funcionario['nome'] ?? '') ?>"
                disabled>

              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="<?= htmlspecialchars($funcionario['email'] ?? '') ?>"
                disabled>
            </div>

            <div class="dados">
              <label for="data_nascimento">Data de nascimento</label>
              <input type="text" name="data_nascimento" id="data_nascimento"
                value="<?= htmlspecialchars($dataNascFormatada ?? '') ?>" disabled>

              <label for="telefone">Telefone</label>
              <input type="text" name="telefone" id="telefone"
                value="<?= htmlspecialchars($funcionario['telefone'] ?? '') ?>" disabled>

              <button type="button" class="alterar-dados" id="btn-alterar-dados">Alterar dados</button>
              <button type="submit" class="alterar-dados" id="btn-salvar-dados" style="display:none;">Salvar
                alterações</button>
            </div>
          </div>
        </form>
      </div>

      <!-- Seção de Produtos cadastrados -->
      <div class="produtos-cadastrados" id="produtos-cadastrados" style="display:none;">
        <div class="titulo-categoria">
          <h3>Produtos cadastrados</h3>
          <select class="opcao" id="filtro-categoria" name="tipo" required>
            <option value="Todos" <?= ($categoria_filtro === 'Todos') ? 'selected' : '' ?>>Todos</option>
            <option value="Rações" <?= ($categoria_filtro === 'Rações') ? 'selected' : '' ?>>Rações</option>
            <option value="Aperitivos" <?= ($categoria_filtro === 'Aperitivos') ? 'selected' : '' ?>>Aperitivos</option>
            <option value="Coleiras" <?= ($categoria_filtro === 'Coleiras') ? 'selected' : '' ?>>Coleiras</option>
            <option value="Brinquedos" <?= ($categoria_filtro === 'Brinquedos') ? 'selected' : '' ?>>Brinquedos</option>
            <option value="Higiene" <?= ($categoria_filtro === 'Higiene') ? 'selected' : '' ?>>Higiene</option>
          </select>
        </div>

        <?php foreach ($produtos as $produto):
          $nome_imagem = str_replace('uploads/imgProdutos/', '', $produto['nome_imagem']);
          $caminho_imagem = "/TCC/public/uploads/imgProdutos/" . $nome_imagem;
          $caminho_absoluto = $_SERVER['DOCUMENT_ROOT'] . '/TCC/public/uploads/imgProdutos/' . $nome_imagem; ?>
          <div class="produto-info">
            <div class="box-img">
              <img src="<?= $caminho_imagem ?>" alt="<?= htmlspecialchars($produto['nome_produto']) ?>" ?>
            </div>
            <div class="info-txt">
              <p><?= htmlspecialchars($produto['nome_produto']) ?></p>
            </div>
            <div class="info-txt-mp">
              <p>Marca: <?= htmlspecialchars($produto['marca']) ?></p>
              <p>Preço: R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
            </div>
            <div class="categoria-txt">
              <p><?= htmlspecialchars($produto['tipo']) ?></p>
            </div>
            <!-- No loop onde os produtos são exibidos, modifique o botão Alterar: -->
            <div class="btns">
              <button type="button">
                <a class="txt-alterar" href="../views/atualizarProduto.php?id=<?= $produto['id_produto'] ?>"
                  class="btn-alterar">Alterar</a>
              </button>
              <form method="post" action="../controllers/excluirProduto.php">
                <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                <button type="submit" class="btn-excluir-produto">Excluir</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </section>
  </main>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="../../public/js/scriptPerfil.js" <?= time() ?>></script>
  <script src="../../public/js/tema.js"></script>

  <script>

    document.documentElement.classList.add('js-enabled');

    document.addEventListener('DOMContentLoaded', function () {
      // Objeto para armazenar valores originais
      const valoresOriginais = {
        perfil: {}
      };

      // Elementos globais
      const previewFoto = document.getElementById('previewFoto');
      const btnAlterarDados = document.getElementById('btn-alterar-dados');
      const btnSalvarDados = document.getElementById('btn-salvar-dados');
      const btnEnviarFoto = document.getElementById('btn-enviar-foto');
      const inputFoto = document.getElementById('foto');

      // Verificar se a foto padrão está sendo usada
      if (previewFoto && previewFoto.src.includes('user-img.png')) {
        previewFoto.src = '../../public/img/user-img.png';
      }

      // Funções para armazenar valores originais
      function armazenarValoresOriginais() {
        valoresOriginais.perfil = {
          nome: document.getElementById('nome').value,
          email: document.getElementById('email').value,
          data_nascimento: document.getElementById('data_nascimento').value,
          telefone: document.getElementById('telefone').value
        };
      }

      // Funções para restaurar valores originais
      function restaurarValoresOriginais() {
        document.getElementById('nome').value = valoresOriginais.perfil.nome;
        document.getElementById('email').value = valoresOriginais.perfil.email;
        document.getElementById('data_nascimento').value = valoresOriginais.perfil.data_nascimento;
        document.getElementById('telefone').value = valoresOriginais.perfil.telefone;
      }

      // Função para alternar entre seções
      function mostrarSecao(secaoId) {
        // Esconder todas as seções
        document.querySelectorAll('section > div').forEach(div => {
          div.style.display = 'none';
        });

        // Mostrar a seção selecionada
        const secao = document.getElementById(secaoId);
        if (secao) {
          secao.style.display = 'block';
        }

        // Atualizar menu ativo
        document.querySelectorAll('.item-menu').forEach(item => {
          item.classList.remove('ativo');
        });

        const menuItem = document.querySelector(`.item-menu[data-section="${secaoId}"]`);
        if (menuItem) {
          menuItem.classList.add('ativo');
        }
      }

      // Função para resetar formulários
      function resetarFormularios() {
        // Verificar se há alterações não salvas no perfil
        if (btnSalvarDados && btnSalvarDados.style.display === 'block') {
          restaurarValoresOriginais();
        }

        // Desabilitar todos os inputs
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], input[type="tel"]').forEach(input => {
          input.disabled = true;
          input.classList.remove('editando');
        });

        // Resetar botões do perfil
        if (btnAlterarDados) btnAlterarDados.style.display = 'block';
        if (btnSalvarDados) btnSalvarDados.style.display = 'none';
        if (btnEnviarFoto) btnEnviarFoto.style.display = 'none';
      }

      // Configurar menu lateral
      document.querySelectorAll('.menu-lateral a[href^="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          resetarFormularios();
          const secaoId = this.getAttribute('href').substring(1);
          mostrarSecao(secaoId);
          history.pushState(null, null, `#${secaoId}`);
        });
      });

      // Verificar hash na URL
      function verificarHash() {
        const hash = window.location.hash.substring(1);
        const secoesValidas = ['perfil-section', 'produtos-cadastrados'];

        resetarFormularios();

        if (hash && secoesValidas.includes(hash)) {
          mostrarSecao(hash);
        } else {
          mostrarSecao('perfil-section');
        }
      }

      // Evento para alterar dados do perfil
      if (btnAlterarDados) {
        btnAlterarDados.addEventListener('click', function () {
          armazenarValoresOriginais();
          document.querySelectorAll('#perfil-section input').forEach(input => {
            input.disabled = false;
            input.classList.add('editando');
          });
          this.style.display = 'none';
          if (btnSalvarDados) btnSalvarDados.style.display = 'block';
          if (btnEnviarFoto) btnEnviarFoto.style.display = 'inline-block';
        });
      }

      // Máscara para data de nascimento
      const inputDataNasc = document.querySelector('input[name="data_nascimento"]');
      if (inputDataNasc) {
        inputDataNasc.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 2) value = value.substring(0, 2) + '/' + value.substring(2);
          if (value.length > 5) value = value.substring(0, 5) + '/' + value.substring(5, 9);
          e.target.value = value;
        });
      }

      // Preview da foto
      if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function (e) {
          const file = e.target.files[0];
          if (file) {
            if (!file.type.match('image.*')) {
              Toastify({
                text: "Por favor, selecione um arquivo de imagem válido.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                  background: "linear-gradient(to right, #cd1809, #a01006)"
                }
              }).showToast();
              return;
            }

            if (file.size > 2 * 1024 * 1024) {
              Toastify({
                text: "A imagem deve ter no máximo 2MB.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                style: {
                  background: "linear-gradient(to right, #cd1809, #a01006)"
                }
              }).showToast();
              return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
              previewFoto.src = e.target.result;
            }
            reader.readAsDataURL(file);
          }
        });
      }


      // Inicialização
      window.addEventListener('hashchange', verificarHash);
      verificarHash();
    });

    document.getElementById('filtro-categoria').addEventListener('change', function () {
      const categoria = this.value;
      const novaUrl = window.location.pathname + '?categoria=' + encodeURIComponent(categoria) + '#produtos-cadastrados';

      // Atualiza a URL sem recarregar (para evitar scroll automático)
      history.pushState(null, '', novaUrl);

      // Recarrega a página
      window.location.reload();
    });

    // Verifica se há categoria na URL ao carregar a página
    document.addEventListener('DOMContentLoaded', function () {
      const urlParams = new URLSearchParams(window.location.search);
      const categoria = urlParams.get('categoria');

      if (categoria) {
        document.getElementById('filtro-categoria').value = categoria;
      }

      document.querySelectorAll('.btn-excluir-produto').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();
          const form = this.closest('form');

          // Criar elemento div para conter a mensagem e os botões
          const toastContent = document.createElement('div');
          toastContent.innerHTML = `
            <div>Deseja realmente excluir este produto?</div>
            <div class="toastify-buttons-container">
                <button class="toastify-button toastify-confirm">Sim</button>
                <button class="toastify-button toastify-cancel">Não</button>
            </div>
        `;

          // Criar o Toastify
          const toast = Toastify({
            node: toastContent,
            duration: -1,  // -1 means the toast won't auto-close
            gravity: "top",
            position: "right",
            style: {
              background: "linear-gradient(to right, white, white)", // Fixed gradient syntax
              padding: '15px',
              width: '300px',
              border: '1px solid grey',
              color: 'black'
            },
            onClick: function () { } // Prevents closing when clicked
          });

          // Show the toast
          toast.showToast();

          // Adicionar eventos aos botões
          const toastElement = toast.toastElement;
          toastElement.querySelector('.toastify-confirm').addEventListener('click', function () {
            if (form) {
              form.submit();
            }
            toast.hideToast();
          });

          toastElement.querySelector('.toastify-cancel').addEventListener('click', function () {
            toast.hideToast();
          });
        });
      });
    });
  </script>
</body>

</html>