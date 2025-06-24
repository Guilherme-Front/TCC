<?php

session_start()
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../public/css/pagamento.css?v=<?= time() ?>">
  <title>Forma de Pagamento</title>

</head>

<body>
  <section>
    <div class="container">
      <div class="payment-section">

        <div class="voltar-text">
          <a href="../views/telaCarrinho.php">
            <img class="botao-voltar" src="../../public/img/voltar.png" alt="botão voltar" />
          </a>

          <h2>Forma de Pagamento</h2>
        </div>

        <div class="payment-option" onclick="selectPayment('pix')">
          <strong>PIX</strong><br>
          <small>Até 5% de desconto • Aprovação imediata</small>
        </div>

        <div class="payment-option" onclick="selectPayment('credit')">
          <strong>Cartão de Crédito</strong><br>
          <small>Parcele em até 3x sem juros</small>
        </div>

        <!-- Formulário PIX -->
        <div id="pix" class="form-section">
          <h3>Pagamento via PIX</h3>
          <p>Você receberá um QR Code após finalizar o pedido.</p>
        </div>

        <!-- Formulário Cartão de Crédito -->
        <div id="credit" class="form-section">
          <h3>Pagamento com Cartão</h3>
          <input type="text" placeholder="Número do cartão" required>
          <input type="text" placeholder="Nome impresso no cartão" required>
          <input type="text" placeholder="Validade (MM/AA)" required>
          <input type="text" placeholder="Código de segurança (CVV)" required>
          <input type="text" placeholder="CPF/CNPJ do titular" required>
        </div>

      </div>

      <!-- Resumo do Pedido -->
      <div class="resumo">
        <h3>Resumo do Pedido</h3>
        <p>Valor dos Produtos: <strong id="valor-produtos">R$ 0,00</strong></p>
        <p id="desconto-section" style="display:none;">Descontos: <span id="desconto" style="color:green;">- R$
            0,00</span></p>
        <p>Frete: <strong>R$ 0,00</strong></p>
        <p class="total">Total a Pagar: <span id="valor-total">R$ 0,00</span></p>
        <div class="button-container">
          <button class="btn" onclick="finalizarPagamento()">Continuar</button>
        </div>
      </div>
    </div>
  </section>

<script>
  let selectedPayment = '';

  function selectPayment(method) {
    selectedPayment = method;
    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
    document.querySelectorAll('.form-section').forEach(form => form.classList.remove('active'));
    document.getElementById(method).classList.add('active');
    event.currentTarget.classList.add('selected');
  }

  function carregarResumo() {
  const carrinhoKey = `carrinho_${<?= $_SESSION['id_cliente'] ?? 0 ?>}`;
  const carrinho = JSON.parse(localStorage.getItem(carrinhoKey)) || [];

  let valorTotalProdutos = 0;
  const resumoContainer = document.getElementById('resumo-produtos');
  if (resumoContainer) resumoContainer.innerHTML = '';

  carrinho.forEach(produto => {
    const subtotal = produto.preco * produto.quantidade;
    valorTotalProdutos += subtotal;

    if (resumoContainer) {
      const p = document.createElement('p');
      p.innerText = `${produto.nome} x${produto.quantidade} - R$ ${subtotal.toFixed(2).replace('.', ',')}`;
      resumoContainer.appendChild(p);
    }
  });

  document.getElementById('valor-produtos').innerText = `R$ ${valorTotalProdutos.toFixed(2).replace('.', ',')}`;
  }

  async function finalizarPagamento() {
    if (!selectedPayment) {
      alert('Por favor, selecione uma forma de pagamento.');
      return;
    }

    // Se for PIX, apenas exibe uma simulação de sucesso
    if (selectedPayment === 'pix') {
      alert('Pedido finalizado com sucesso via PIX! (Aqui você pode gerar o QR code)');
    }

    // Se for Cartão, valide os campos (exemplo simples)
    if (selectedPayment === 'credit') {
      const inputs = document.querySelectorAll('#credit input');
      let preenchido = true;

      inputs.forEach(input => {
        if (input.value.trim() === '') preenchido = false;
      });

      if (!preenchido) {
        alert('Por favor, preencha todos os dados do cartão.');
        return;
      }

      alert('Pagamento com cartão processado com sucesso! (Aqui você pode integrar com API de pagamento)');
    }

    // window.location.href = 'pedidoRealizado.php';
  }

  // Atualiza resumo sempre que um método de pagamento for selecionado
  document.querySelectorAll('.payment-option').forEach(opt => {
    opt.addEventListener('click', carregarResumo);
  });

  // Carrega o valor inicial ao abrir a página
  document.addEventListener('DOMContentLoaded', carregarResumo);
</script>

</body>
</html>
