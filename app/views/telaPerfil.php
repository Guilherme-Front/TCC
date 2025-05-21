<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

$id_cliente = $_SESSION['id_cliente'] ?? null;

if (!$id_cliente) {
  header('Location: Login.php');
  exit();
}

if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Busca os dados do cliente
$stmt = $conn->prepare("SELECT nome, email, telefone, datNasc, foto FROM cliente WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

// Busca os dados do endereço
$stmt_endereco = $conn->prepare("SELECT cep, rua, bairro, cidade, numero, complemento FROM endereco WHERE id_cliente = ?");
$stmt_endereco->bind_param("i", $id_cliente);
$stmt_endereco->execute();
$result_endereco = $stmt_endereco->get_result();
$endereco = $result_endereco->fetch_assoc();

// Formata o CEP (adiciona hífen) se existir
if (!empty($endereco['cep'])) {
  $endereco['cep'] = substr($endereco['cep'], 0, 5) . '-' . substr($endereco['cep'], 5, 3);
}

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

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="../../public/css/perfil.css?v=<?= time() ?>">
  <link rel="icon" type="image/x-icon" href="../../public/img/favicon-32x32.png">
  <title>Tela de Perfil | Pet Insight</title>
</head>

<body>
  <?php if (isset($_SESSION['toast'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
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
          onClick: function() {}
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
          <li class="item-menu ativo" data-section="perfil-section">
            <a href="#perfil-section">
              <span class="icon"><img class="icons-img" src="../../public/img/file-user.png" alt="usuário"
                  id="file"></span>
              <span class="txt-link">Meus dados</span>
            </a>
          </li>

          <li class="item-menu" data-section="pedidos-section">
            <a href="#pedidos-section">
              <span class="icon"><img class="icons-img" src="../../public/img/order-history.png" alt="pedidos"
                  id="order"></span>
              <span class="txt-link">Meus pedidos</span>
            </a>
          </li>

          <li class="item-menu" data-section="suporte-section">
            <a href="../views/FaleConosco.php">
              <span class="icon"><img class="icons-img" src="../../public/img/suggestion.png" alt="suporte"
                  id="mapa"></span>
              <span class="txt-link">Suporte</span>
            </a>
          </li>

          <li class="item-menu" data-section="endereco-section">
            <a href="#endereco-section">
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

      <!-- Seção de Perfil -->
      <div class="perfil-section" id="perfil-section">
        <form action="../controllers/PerfilController.php" method="post" enctype="multipart/form-data">
          <div class="img-txt">
            <div class="foto-container">
              <?php if (isset($cliente['foto']) && !empty($cliente['foto'])): ?>
                <!-- Exibe a foto do usuário se cadastrada -->
                <img class="gato" id="previewFoto"
                  src="../../public/uploads/imgUsuarios/<?= $id_cliente . '/' . htmlspecialchars($cliente['foto']) ?>"
                  alt="Foto do perfil" />
              <?php else: ?>
                <!-- Exibe a imagem padrão caso não tenha foto cadastrada -->
                <img src="../../public/img/user-img.png" class="gato" id="previewFoto" alt="Foto do perfil" />
              <?php endif; ?>

              <p class="boas-vindas">Olá
                <strong>
                  <?= !empty($cliente['nome']) ? htmlspecialchars($cliente['nome']) : 'Usuário' ?>!
                </strong>
              </p>
            </div>

            <div class="flex-enviar">
              <!-- Input de foto escondido inicialmente -->
              <input type="file" name="foto" id="foto" class="enviar-foto" hidden>

              <!-- Botão de enviar foto -->
              <label for="foto" class="enviar-foto" id="btn-enviar-foto" style="display: none;">Enviar foto</label>

            </div>
          </div>

          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

          <div class="dados-pessoais">
            <div class="dados">
              <label for="nome">Nome completo</label>
              <input type="text" name="nome" id="nome"
                value="<?= isset($cliente['nome']) ? htmlspecialchars($cliente['nome']) : '' ?>" disabled>

              <label for="email">Email</label>
              <input type="email" name="email" id="email"
                value="<?= isset($cliente['email']) ? htmlspecialchars($cliente['email']) : '' ?>" disabled>

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

      <!-- Seção de Endereço -->
      <div class="endereco-section" id="endereco-section" style="display:none;">
        <form action="../controllers/enderecoController.php" method="post">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

          <div class="dados-endereco">
            <div class="linha-endereco">
              <div class="campo-endereco cep">
                <label for="cep">CEP</label>
                <div class="cep-input-group">
                  <input class="cep" type="text" name="cep" id="cep" placeholder="00000-000"
                    value="<?= isset($endereco['cep']) ? htmlspecialchars($endereco['cep']) : '' ?>" disabled>
                </div>
                <span id="cep-error" class="error-message" style="color:red; display:none;"></span>
              </div>
              <div class="campo-endereco cidade">
                <label for="cidade">Cidade</label>
                <input class="input-txt" type="text" name="cidade" id="cidade" placeholder="Digite o nome da cidade"
                  value="<?= isset($endereco['cidade']) ? htmlspecialchars($endereco['cidade']) : '' ?>" disabled>
              </div>
            </div>

            <div class="linha-endereco">
              <div class="campo-endereco rua">
                <label for="rua">Rua</label>
                <input class="input-txt" type="text" name="rua" id="rua" placeholder="Digite o nome da rua"
                  value="<?= isset($endereco['rua']) ? htmlspecialchars($endereco['rua']) : '' ?>" disabled>
              </div>

              <div class="campo-endereco bairro">
                <label for="bairro">Bairro</label>
                <input class="input-txt" type="text" name="bairro" id="bairro" placeholder="Digite o nome do bairro"
                  value="<?= isset($endereco['bairro']) ? htmlspecialchars($endereco['bairro']) : '' ?>" disabled>
              </div>

              <div class="campo-endereco numero">
                <label for="numero">Número</label>
                <input class="numero" type="text" name="numero" id="numero" placeholder="0000" maxlength="4"
                  value="<?= isset($endereco['numero']) ? htmlspecialchars($endereco['numero']) : '' ?>" disabled>
              </div>
            </div>

            <div class="linha-endereco complemento-full">
              <div class="campo-endereco complemento">
                <label for="complemento">Complemento (opcional)</label>
                <input class="input-txt" type="text" name="complemento" id="complemento" placeholder="Complemento"
                  value="<?= isset($endereco['complemento']) ? htmlspecialchars($endereco['complemento']) : '' ?>"
                  disabled>
              </div>
            </div>
          </div>

          <div class="botoes-endereco">
            <button type="button" class="alterar-dados" id="btn-alterar-endereco">Alterar dados</button>
            <button type="submit" class="salvar-dados" id="btn-salvar-endereco" style="display:none;">Salvar
              alterações</button>
          </div>
        </form>
      </div>
      <!-- Seção de Pedidos -->
      <div class="pedidos-section" id="pedidos-section" style="display:none;">
        <?php include 'pedidos.php'; ?>
      </div>

    </section>
  </main>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="../../public/js/tema.js"></script>
  <script src="../../public/js/scriptPerfil.js" <?= time() ?>></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Objeto para armazenar valores originais
      const valoresOriginais = {
        perfil: {},
        endereco: {}
      };

      // Elementos globais
      const previewFoto = document.getElementById('previewFoto');
      const btnAlterarDados = document.getElementById('btn-alterar-dados');
      const btnSalvarDados = document.getElementById('btn-salvar-dados');
      const btnEnviarFoto = document.getElementById('btn-enviar-foto');
      const btnAlterarEndereco = document.getElementById('btn-alterar-endereco');
      const btnSalvarEndereco = document.getElementById('btn-salvar-endereco');
      const inputFoto = document.getElementById('foto');
      const cepInput = document.getElementById('cep');
      const cepError = document.getElementById('cep-error');

      // Estado para controlar se o CEP é válido
      let cepValido = false;

      // Verificar se a foto padrão está sendo usada
      if (previewFoto && previewFoto.src.includes('user-img.png')) {
        previewFoto.src = '../../public/img/user-img.png';
      }

      // Funções para armazenar valores originais
      function armazenarValoresOriginais(secao) {
        if (secao === 'perfil') {
          valoresOriginais.perfil = {
            nome: document.getElementById('nome').value,
            email: document.getElementById('email').value,
            data_nascimento: document.getElementById('data_nascimento').value,
            telefone: document.getElementById('telefone').value
          };
        } else if (secao === 'endereco') {
          valoresOriginais.endereco = {
            cep: cepInput.value,
            cidade: document.getElementById('cidade').value,
            rua: document.getElementById('rua').value,
            bairro: document.getElementById('bairro').value,
            numero: document.getElementById('numero').value,
            complemento: document.getElementById('complemento').value
          };
        }
      }

      // Funções para restaurar valores originais
      function restaurarValoresOriginais(secao) {
        if (secao === 'perfil' && valoresOriginais.perfil) {
          document.getElementById('nome').value = valoresOriginais.perfil.nome;
          document.getElementById('email').value = valoresOriginais.perfil.email;
          document.getElementById('data_nascimento').value = valoresOriginais.perfil.data_nascimento;
          document.getElementById('telefone').value = valoresOriginais.perfil.telefone;
        } else if (secao === 'endereco' && valoresOriginais.endereco) {
          cepInput.value = valoresOriginais.endereco.cep;
          document.getElementById('cidade').value = valoresOriginais.endereco.cidade;
          document.getElementById('rua').value = valoresOriginais.endereco.rua;
          document.getElementById('bairro').value = valoresOriginais.endereco.bairro;
          document.getElementById('numero').value = valoresOriginais.endereco.numero;
          document.getElementById('complemento').value = valoresOriginais.endereco.complemento;
        }
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
        // Limpar mensagens de erro do CEP
        if (cepError) {
          cepError.textContent = '';
          cepError.style.display = 'none';
        }

        // Remover classe de erro
        const cepGroup = document.querySelector('.cep-input-group');
        if (cepGroup) {
          cepGroup.classList.remove('has-error');
        }

        // Resetar estado de validação
        cepValido = false;

        // Verificar se há alterações não salvas no perfil
        if (btnSalvarDados && btnSalvarDados.style.display === 'block') {
          restaurarValoresOriginais('perfil');
        }

        // Verificar se há alterações não salvas no endereço
        if (btnSalvarEndereco && btnSalvarEndereco.style.display === 'block') {
          restaurarValoresOriginais('endereco');
        }

        // Desabilitar todos os inputs
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="date"], input[type="tel"]').forEach(input => {
          input.disabled = true;
          input.classList.remove('editando');
          input.classList.remove('campo-invalido');
        });

        // Resetar botões do perfil
        if (btnAlterarDados) btnAlterarDados.style.display = 'block';
        if (btnSalvarDados) btnSalvarDados.style.display = 'none';
        if (btnEnviarFoto) btnEnviarFoto.style.display = 'none';

        // Resetar botões de endereço
        if (btnAlterarEndereco) btnAlterarEndereco.style.display = 'block';
        if (btnSalvarEndereco) btnSalvarEndereco.style.display = 'none';
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
        const secoesValidas = ['perfil-section', 'endereco-section', 'pedidos-section'];

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
          armazenarValoresOriginais('perfil');
          document.querySelectorAll('#perfil-section input').forEach(input => {
            input.disabled = false;
            input.classList.add('editando');
          });
          this.style.display = 'none';
          if (btnSalvarDados) btnSalvarDados.style.display = 'block';
          if (btnEnviarFoto) btnEnviarFoto.style.display = 'inline-block';
        });
      }

      // Evento para alterar endereço
      if (btnAlterarEndereco) {
        btnAlterarEndereco.addEventListener('click', function () {
          // Limpa erros anteriores ao começar nova edição
          if (cepError) {
            cepError.textContent = '';
            cepError.style.display = 'none';
          }

          const cepGroup = document.querySelector('.cep-input-group');
          if (cepGroup) {
            cepGroup.classList.remove('has-error');
          }

          // Resetar estado de validação
          cepValido = false;

          armazenarValoresOriginais('endereco');
          const enderecoInputs = document.querySelectorAll('#endereco-section input');

          enderecoInputs.forEach(input => {
            input.disabled = false;
            input.classList.add('editando');
          });

          this.style.display = 'none';
          if (btnSalvarEndereco) btnSalvarEndereco.style.display = 'block';

          // Foca no primeiro campo (CEP)
          if (cepInput) cepInput.focus();
        });
      }

      // Evento para salvar endereço (validação antes de enviar)
      if (btnSalvarEndereco) {
        btnSalvarEndereco.addEventListener('click', async function (e) {
          e.preventDefault(); // Impede o envio padrão do formulário

          let formularioValido = true;

          // Validação do CEP (deve ter 8 dígitos e ser válido)
          if (cepInput) {
            const cepValue = cepInput.value.replace(/\D/g, '');

            if (cepValue.length !== 8) {
              mostrarErroCEP('CEP deve conter 8 dígitos');
              cepInput.focus();
              formularioValido = false;
              cepValido = false;
            } else if (!cepValido) {
              // Se o CEP tem 8 dígitos mas não foi validado ainda
              const valido = await verificarCEP(cepValue);
              if (!valido) {
                mostrarErroCEP('CEP inválido ou não encontrado');
                formularioValido = false;
                cepValido = false;
                return;
              }
            }
          }

          // Validação do número (deve ser numérico e entre 1-9999)
          const numeroInput = document.getElementById('numero');
          if (numeroInput) {
            const numeroValue = parseInt(numeroInput.value);

            if (!numeroInput.value || isNaN(numeroValue) || numeroValue < 1 || numeroValue > 9999) {
              alert('Número deve ser um valor entre 1 e 9999');
              numeroInput.classList.add('campo-invalido');
              numeroInput.focus();
              formularioValido = false;
            } else {
              numeroInput.classList.remove('campo-invalido');
            }
          }

          // Validação dos campos obrigatórios
          const camposObrigatorios = ['rua', 'bairro', 'cidade'];
          let camposVazios = [];

          camposObrigatorios.forEach(campo => {
            const input = document.getElementById(campo);
            if (input && !input.value.trim()) {
              camposVazios.push(campo);
              input.classList.add('campo-invalido');
              formularioValido = false;
            } else if (input) {
              input.classList.remove('campo-invalido');
            }
          });

          if (camposVazios.length > 0) {
            alert('Por favor, preencha todos os campos obrigatórios');
            const primeiroCampo = document.getElementById(camposVazios[0]);
            if (primeiroCampo) primeiroCampo.focus();
          }

          // Se tudo estiver válido, submete o formulário
          if (formularioValido && cepValido) {
            document.querySelector('#endereco-section form').submit();
          }
        });
      }

      // Função para verificar se o CEP é válido
      async function verificarCEP(cep) {
        try {
          const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
          const data = await response.json();
          return !data.erro;
        } catch (error) {
          console.error('Erro ao verificar CEP:', error);
          return false;
        }
      }

      // Função para buscar e preencher dados do CEP
      async function buscarCEP(cep) {
        cep = cep.replace(/\D/g, '');

        if (cep.length !== 8) {
          mostrarErroCEP('CEP deve conter 8 dígitos');
          cepValido = false;
          return false;
        }

        if (cepInput) cepInput.classList.add('loading');
        if (cepError) cepError.style.display = 'none';

        try {
          const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
          const data = await response.json();

          if (data.erro) {
            throw new Error('CEP não encontrado');
          }

          // Preenche os campos apenas se existirem
          const rua = document.getElementById('rua');
          const bairro = document.getElementById('bairro');
          const cidade = document.getElementById('cidade');

          if (rua) rua.value = data.logradouro || '';
          if (bairro) bairro.value = data.bairro || '';
          if (cidade) cidade.value = data.localidade || '';

          // Marca o CEP como válido
          cepValido = true;

          // Foca no campo número
          const numero = document.getElementById('numero');
          if (numero) numero.focus();

          return true;
        } catch (error) {
          console.error('Erro ao buscar CEP:', error);
          mostrarErroCEP(error.message || 'Erro ao buscar CEP');
          cepValido = false;
          return false;
        } finally {
          if (cepInput) cepInput.classList.remove('loading');
        }
      }

      function mostrarErroCEP(mensagem) {
        if (cepError) {
          cepError.textContent = mensagem;
          cepError.style.display = 'block';
        }
        const cepGroup = document.querySelector('.cep-input-group');
        if (cepGroup) {
          cepGroup.classList.add('has-error');
        }
        cepValido = false;
      }

      // Máscaras de entrada
      const inputDataNasc = document.querySelector('input[name="data_nascimento"]');
      if (inputDataNasc) {
        inputDataNasc.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 2) value = value.substring(0, 2) + '/' + value.substring(2);
          if (value.length > 5) value = value.substring(0, 5) + '/' + value.substring(5, 9);
          e.target.value = value;
        });
      }

      if (cepInput) {
        cepInput.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.length > 5) value = value.substring(0, 5) + '-' + value.substring(5, 8);
          e.target.value = value;

          // Limpa o estado de validação quando o usuário edita
          cepValido = false;

          // Busca automática quando tiver 8 dígitos (9 com hífen)
          if (value.length === 9) {
            buscarCEP(value);
          }
        });

        cepInput.addEventListener('blur', function () {
          if (!this.disabled && this.value.length === 9) {
            buscarCEP(this.value);
          }
        });
      }

      const inputNumero = document.getElementById('numero');
      if (inputNumero) {
        inputNumero.addEventListener('input', function (e) {
          e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
        });

        inputNumero.addEventListener('paste', function (e) {
          e.preventDefault();
          const textoColado = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 4);
          document.execCommand('insertText', false, textoColado);
        });
      }

      // Preview da foto
      if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function (e) {
          const file = e.target.files[0];
          if (file) {
            if (!file.type.match('image.*')) {
              alert('Por favor, selecione um arquivo de imagem');
              return;
            }

            if (file.size > 2 * 1024 * 1024) {
              alert('A imagem deve ter no máximo 2MB');
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
  </script>

</body>

</html>