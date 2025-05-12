<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

$id_cliente = $_SESSION['id_cliente'] ?? null;
echo "ID do usuário logado: " . ($_SESSION['id_cliente'] ?? 'nenhum'); // Mostra qual usuário está logado

if (!$id_cliente) {
  header('Location: Login.html');
  exit();
}

// Gera o token CSRF se não existir
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Busca os dados do cliente
$stmt = $conn->prepare("SELECT nome, email, telefone, datNasc FROM cliente WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

// Formata data de nascimento
$dataNascFormatada = '';
if (!empty($cliente['datNasc']) && $cliente['datNasc'] !== '0000-00-00') {
  $data = DateTime::createFromFormat('Y-m-d', $cliente['datNasc']);
  if ($data) {
    $dataNascFormatada = $data->format('d/m/Y');
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '' ?>">


  <link rel="stylesheet" href="../../public/css/perfil.css?v=<?= time() ?>">
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">

  <title>Tela de Perfil | Pet Insight</title>
</head>

<body>
  <!-- Mensagens de feedback -->
  <?php if (isset($_SESSION['sucesso'])): ?>
    <div class="alert alert-success"><?= $_SESSION['sucesso'];
    unset($_SESSION['sucesso']); ?></div>
  <?php endif; ?>

  <?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['erro'];
    unset($_SESSION['erro']); ?></div>
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

    <div class="carrinho">
      <a href="../views/TelaCarrinho.php">
        <img class="carrinho-compras" src="../../public/img/carrinho.png" alt="carrinho de compras" />
      </a>
    </div>
  </div>

  <main>
    <aside>
      <nav class="menu-lateral">
        <ul>
          <li class="item-menu ativo">
            <a href="perfil.php">
              <span class="icon"><img class="icons-img" src="../../public/img/file-user.png" alt="usuário"
                  id="file"></span>
              <span class="txt-link">Meus dados</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="pedidos.php">
              <span class="icon"><img class="icons-img" src="../../public/img/order-history.png" alt="pedidos"
                  id="order"></span>
              <span class="txt-link">Meus pedidos</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="suporte.php">
              <span class="icon"><img class="icons-img" src="../../public/img/suggestion.png" alt="suporte"
                  id="mapa"></span>
              <span class="txt-link">Suporte</span>
            </a>
          </li>

          <li class="item-menu">
            <a href="enderecos.php">
              <span class="icon"><img class="icons-img" src="../../public/img/map-marker-home.png" alt="endereço"
                  id="house"></span>
              <span class="txt-link">Endereço</span>
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
      <div class="perfil">
        <form action="../controllers/PerfilController.php" method="post" enctype="multipart/form-data">
          <div class="img-txt">
            <?php if (!empty($cliente['foto'])): ?>
              <!-- Exibe a foto do usuário se cadastrada -->
              <img class="gato" id="previewFoto"
                src="../../public/uploads/imgUsuarios/<?= $id_cliente . '/' . htmlspecialchars($cliente['foto'] ?? 'gato.jpg') ?>"
                data-foto="<?= htmlspecialchars($cliente['foto'] ?? '') ?>" alt="Foto do perfil" />
            <?php else: ?>
              <!-- Exibe a imagem padrão caso não tenha foto cadastrada -->
              <img class="gato" id="previewFoto" alt="Foto do perfil" />
            <?php endif; ?>
            <p class="boas-vindas">Olá
              <strong>
                <?= !empty($cliente['nome']) ? htmlspecialchars($cliente['nome']) : 'Usuário' ?>!
              </strong>
            </p>
          </div>

          <!-- Input de foto escondido inicialmente -->
          <input type="file" name="foto" id="foto" class="enviar-foto" hidden>

          <!-- Botão de enviar foto escondido inicialmente -->
          <label for="foto" class="enviar-foto" id="btn-enviar-foto" style="display: none;">Enviar foto</label>


          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

          <div class="dados-pessoais">
            <div class="dados">
              <label for="nome">Nome completo</label>
              <input type="text" name="nome" id="nome"
                value="<?= isset($cliente['nome']) ? htmlspecialchars($cliente['nome']) : '' ?>" disabled>

              <label for="email">Email</label>
              <input type="email" name="email" id="email"
                value="<?= isset($cliente['email']) ? htmlspecialchars($cliente['email']) : '' ?>" disabled>

              <label>Senha</label>
              <div class="password-field">
                <a href="alterar_senha.php" class="change-password">Alterar senha</a>
              </div>
            </div>

            <div class="dados">
              <label for="data_nascimento">Data de nascimento</label>
              <input type="text" name="data_nascimento" id="data_nascimento"
                value="<?= isset($dataNascFormatada) ? htmlspecialchars($dataNascFormatada) : '' ?>" disabled>

              <label for="telefone">Telefone</label>
              <input type="text" name="telefone" id="telefone"
                value="<?= isset($cliente['telefone']) ? htmlspecialchars($cliente['telefone']) : '' ?>" disabled>

              <button type="button" class="alterar-dados" id="btn-alterar-dados">Alterar dados</button>
              <button type="submit" class="alterar-dados" id="btn-salvar-dados" style="display:none;">Salvar
                alterações</button>
            </div>
          </div>
        </form>
      </div>


    </section>
  </main>

  <script src="../../public/js/tema.js"></script>
  <script src="../../public/js/scriptPerfil.js"></script>

  <script>
    // Habilitar edição dos campos ao clicar no botão
    window.onload = function () {
      const preview = document.getElementById('previewFoto');
      const fotoCadastrada = preview.src; // Pega o src da foto (pode ser a foto do usuário ou a padrão)

      // Se a foto cadastrada for a padrão (do gato), exibe ela
      if (fotoCadastrada.includes('gato.jpg')) {
        preview.src = '../../public/img/gato.jpg'; // Se não houver foto, mostra a foto padrão
      }
    };

    // Habilita a edição dos campos ao clicar no botão
    document.getElementById('btn-alterar-dados').addEventListener('click', function () {
      // Habilita todos os inputs que estão desabilitados
      document.querySelectorAll('input[disabled]').forEach(input => {
        input.disabled = false;
      });

      // Troca a visibilidade dos botões
      this.style.display = 'none';
      document.getElementById('btn-salvar-dados').style.display = 'block';

      // Alterna a visibilidade do botão de enviar foto
      const btnEnviarFoto = document.getElementById('btn-enviar-foto');
      if (btnEnviarFoto.style.display === 'none' || btnEnviarFoto.style.display === '') {
        btnEnviarFoto.style.display = 'inline-block';  // Exibe o botão de enviar foto
      }
    });

    // Validação de data (formatação automática: dd/mm/yyyy)
    document.querySelector('input[name="data_nascimento"]').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número
      if (value.length > 2) value = value.substring(0, 2) + '/' + value.substring(2);
      if (value.length > 5) value = value.substring(0, 5) + '/' + value.substring(5, 9);
      e.target.value = value;
    });

  </script>

</body>

</html>