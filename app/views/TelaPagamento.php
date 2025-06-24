<?php

session_start()
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Forma de Pagamento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 20px auto;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .payment-section {
      flex: 1;
      min-width: 300px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
    }

    h2, h3 {
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    .payment-option {
      border: 1px solid #FFA500;
      border-radius: 6px;
      padding: 15px;
      margin-bottom: 15px;
      cursor: pointer;
      background-color: #fff8e1;
    }

    .payment-option.selected {
      border: 2px solid #FFA500;
      background-color: #fff3cd;
    }

    .form-section {
      display: none;
      margin-top: 10px;
    }

    .form-section.active {
      display: block;
    }

    .form-section input {
      width: 100%;
      padding: 8px;
      margin: 5px 0 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn {
      background-color: #FFA500;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #e69500;
    }

    .resumo {
      flex: 0.4;
      min-width: 250px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      height: fit-content;
    }

    .resumo p {
      margin: 8px 0;
      font-size: 15px;
    }

    .total {
      font-weight: bold;
      color: #28a745;
      font-size: 16px;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Seção de pagamento -->
  <div class="payment-section">
    <h2>Forma de Pagamento</h2>

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
    <p id="desconto-section" style="display:none;">Descontos: <span id="desconto" style="color:green;">- R$ 0,00</span></p>
    <p>Frete: <strong>R$ 0,00</strong></p>
    <p class="total">Total a Pagar: <span id="valor-total">R$ 0,00</span></p>
    <button class="btn" onclick="finalizarPagamento()">Continuar</button>
  </div>
  
</div>

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
    let total = localStorage.getItem('valorTotalCompra') || "0.00";
    total = parseFloat(total);

    document.getElementById('valor-produtos').innerText = `R$ ${total.toFixed(2).replace('.', ',')}`;

    // Exemplo: Aplicando 5% de desconto se for PIX (simulando lógica futura)
    let desconto = 0;
    if (selectedPayment === 'pix') {
      desconto = total * 0.05;
      document.getElementById('desconto-section').style.display = 'block';
      document.getElementById('desconto').innerText = `- R$ ${desconto.toFixed(2).replace('.', ',')}`;
    } else {
      document.getElementById('desconto-section').style.display = 'none';
    }

    const totalFinal = total - desconto;

    document.getElementById('valor-total').innerText = `R$ ${totalFinal.toFixed(2).replace('.', ',')}`;
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

    // Aqui você pode redirecionar para uma página de "Pedido Realizado"
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
