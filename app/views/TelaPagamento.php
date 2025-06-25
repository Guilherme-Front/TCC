<?php

session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../public/css/pagamento.css?v=<?= time() ?>">
  <title>Forma de Pagamento</title>
  <script src="https://sdk.mercadopago.com/js/v2"></script>
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
  <form id="form-checkout">
    <input type="text" id="cardNumber" placeholder="Número do cartão" />
    <input type="text" id="cardholderName" placeholder="Nome impresso no cartão" />
    <input type="text" id="expirationDate" placeholder="Validade (MM/AA)" />
    <input type="text" id="securityCode" placeholder="CVV" />
    <input type="text" id="docNumber" placeholder="CPF do titular" />

    <input type="hidden" id="paymentMethodId" name="paymentMethodId" />
    
    <label for="installments">Parcelamento:</label>
    <select id="installments" name="installments">
      <option value="">Selecione...</option>
    </select>
  </form>
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
  const mp = new MercadoPago("TEST-97003615-4325-4af4-a575-72490bb84ec4");

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
    carrinho.forEach(produto => {
      const subtotal = produto.preco * produto.quantidade;
      valorTotalProdutos += subtotal;
    });

    document.getElementById('valor-produtos').innerText = `R$ ${valorTotalProdutos.toFixed(2).replace('.', ',')}`;
    document.getElementById('valor-total').innerText = `R$ ${valorTotalProdutos.toFixed(2).replace('.', ',')}`;
  }

  async function obterParcelas(bin, amount) {
    try {
      const response = await mp.getInstallments({ amount, bin });
      const payerCosts = response[0].payer_costs;

      const select = document.getElementById('installments');
      select.innerHTML = '';

      payerCosts.forEach(option => {
        const opt = document.createElement('option');
        opt.value = option.installments;
        opt.textContent = `${option.installments}x de R$ ${option.installment_amount.toFixed(2)} (${option.recommended_message})`;
        select.appendChild(opt);
      });
    } catch (err) {
      console.error('Erro ao obter parcelas:', err);
    }
  }

  document.getElementById('cardNumber').addEventListener('keyup', async function () {
    const number = this.value.replace(/\s/g, '');
    if (number.length >= 6) {
      const bin = number.substring(0, 6);
      const totalText = document.getElementById('valor-total').innerText.replace('R$ ', '').replace('.', '').replace(',', '.');
      const amount = parseFloat(totalText) || 0;
      try {
        const res = await mp.getPaymentMethod({ bin });
        document.getElementById('paymentMethodId').value = res.results[0].id;
        obterParcelas(bin, amount);
      } catch (err) {
        console.warn('Erro ao identificar cartão:', err);
      }
    }
  });

  async function finalizarPagamento() {
    if (!selectedPayment) {
      alert('Selecione uma forma de pagamento');
      return;
    }

    const totalText = document.getElementById('valor-total').innerText.replace('R$ ', '').replace('.', '').replace(',', '.');
    const total = parseFloat(totalText) || 0;

    if (selectedPayment === 'pix') {
      const response = await fetch('../controllers/pagamentoPix.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `total=${total}`
      });
      const data = await response.json();
      if (data.qr_code_base64) {
        const janela = window.open();
        janela.document.write(`<h2>Escaneie o QR Code</h2><img src="data:image/png;base64,${data.qr_code_base64}" />`);
      } else {
        alert('Erro ao gerar QR Code: ' + (data.erro || 'desconhecido'));
      }
    }

    if (selectedPayment === 'credit') {
      const cardData = {
        cardNumber: document.getElementById('cardNumber').value,
        cardholderName: document.getElementById('cardholderName').value,
        expirationDate: document.getElementById('expirationDate').value,
        securityCode: document.getElementById('securityCode').value,
        identification: {
          type: 'CPF',
          number: document.getElementById('docNumber').value
        }
      };

      try {
        const tokenResult = await mp.createCardToken(cardData);
        const token = tokenResult.id;
        const paymentMethodId = document.getElementById('paymentMethodId').value;
        const installments = document.getElementById('installments').value;

        const response = await fetch('../controllers/pagamentoCartao.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({
            total,
            token,
            payment_method_id: paymentMethodId,
            parcelas: installments
          })
        });

        const data = await response.json();
        if (data.status === 'sucesso') {
          alert('Pagamento aprovado! ID: ' + data.id_pagamento);
        } else {
          alert('Falha no pagamento: ' + (data.erro || 'Erro desconhecido'));
        }
      } catch (err) {
        console.error('Erro ao tokenizar ou pagar:', err);
        alert('Erro ao processar pagamento com cartão.');
      }
    }
  }

  document.addEventListener('DOMContentLoaded', carregarResumo);
  </script>

</body>
</html>
