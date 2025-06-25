<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Forma de Pagamento</title>
  <!-- Adicionando Toastify CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
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

    .form-section input, .form-section select {
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

     body { font-family: Arial, sans-serif; background:#f9f9f9; margin:0; padding:0; }
    .container { max-width: 1200px; margin:20px auto; display:flex; gap:20px; flex-wrap:wrap; }
    .payment-section { flex:1; min-width:300px; background:#fff; border:1px solid #ddd; border-radius:8px; padding:20px; }
    h2, h3 { color:#333; border-bottom:1px solid #eee; padding-bottom:10px; }
    .payment-option { border:1px solid #FFA500; border-radius:6px; padding:15px; margin-bottom:15px; cursor:pointer; background:#fff8e1; }
    .payment-option.selected { border:2px solid #FFA500; background:#fff3cd; }
    .form-section { display:none; margin-top:10px; }
    .form-section.active { display:block; }
    .form-section input, .form-section select { width:100%; padding:8px; margin:5px 0 10px 0; border:1px solid #ccc; border-radius:4px; }
    .btn { background:#FFA500; color:#fff; padding:10px 20px; border:none; border-radius:4px; cursor:pointer; margin-top:10px; }
    .btn:hover { background:#e69500; }
    .resumo { flex:0.4; min-width:250px; background:#fff; border:1px solid #ddd; border-radius:8px; padding:20px; height:fit-content; }
    .resumo p { margin:8px 0; font-size:15px; }
    .total { font-weight:bold; color:#28a745; font-size:16px; }
    #qr-code-container img { max-width: 100%; margin-top: 15px; }
    #message { margin-top: 15px; font-weight: bold; }

  </style>
</head>
<body>

<div class="container">
  <div class="payment-section">
    <h2>Forma de Pagamento</h2>

    <div class="payment-option" onclick="selectPayment('pix')">
      <strong>PIX</strong><br>
      <small>Até 22% de desconto • Aprovação imediata</small>
    </div>

    <div class="payment-option" onclick="selectPayment('credit')">
      <strong>Cartão de Crédito</strong><br>
      <small>Parcele em até 6x sem juros</small>
    </div>

    <div id="pix" class="form-section">
      <h3>Pagamento via PIX</h3>
      <p>Você receberá um QR Code após finalizar o pedido.</p>
      <div id="qr-code-container"></div>
    </div>
    
    <div id="credit" class="form-section">
      <h3>Pagamento com Cartão</h3>
      <input type="text" id="numero-cartao" placeholder="Número do cartão" required>
      <input type="text" id="nome-cartao" placeholder="Nome impresso no cartão" required>
      <input type="text" id="validade-cartao" placeholder="Validade (MM/AA)" required>
      <input type="text" id="cvv-cartao" placeholder="Código de segurança (CVV)" required>
      <input type="text" id="cpf-cartao" placeholder="CPF/CNPJ do titular" required>

      <label for="parcelas">Parcelas:</label>
      <select id="parcelas" required>
        <option value="1">1x sem juros</option>
        <option value="2">2x sem juros</option>
        <option value="3">3x sem juros</option>
        <option value="4">4x sem juros</option>
        <option value="5">5x sem juros</option>
        <option value="6">6x sem juros</option>
      </select>
    </div>
  </div>

  <div class="resumo">
    <h3>Resumo do Pedido</h3>
    <p>Valor dos Produtos: <strong id="valor-produtos">R$ 0,00</strong></p>
    <p id="desconto-section" style="display:none;">Descontos: <span id="desconto" style="color:green;">- R$ 0,00</span></p>
    <p class="total">Total a Pagar: <span id="valor-total">R$ 0,00</span></p>
    <button class="btn" onclick="finalizarPagamento()">Continuar</button>



    <div id="message"></div>
  </div>
</div>

<!-- Adicionando Toastify JS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  let selectedPayment = '';

  function selectPayment(method) {
    selectedPayment = method;
    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
    document.querySelectorAll('.form-section').forEach(form => form.classList.remove('active'));
    document.getElementById(method).classList.add('active');
    event.currentTarget.classList.add('selected');
    carregarResumo();
    clearMessage();
    clearQRCode();
  }

  function carregarResumo() {
    let total = localStorage.getItem('valorTotalCompra') || "0.00";
    total = parseFloat(total);

    document.getElementById('valor-produtos').innerText = `R$ ${total.toFixed(2).replace('.', ',')}`;

    let desconto = 0;
    if (selectedPayment === 'pix') {
      desconto = total * 0.05;  // Exemplo 5% de desconto no PIX
      document.getElementById('desconto-section').style.display = 'block';
      document.getElementById('desconto').innerText = `- R$ ${desconto.toFixed(2).replace('.', ',')}`;
    } else {
      document.getElementById('desconto-section').style.display = 'none';
    }

    const totalFinal = total - desconto;
    document.getElementById('valor-total').innerText = `R$ ${totalFinal.toFixed(2).replace('.', ',')}`;
  }

  function clearMessage() {
    document.getElementById('message').innerText = '';
  }

  function clearQRCode() {
    document.getElementById('qr-code-container').innerHTML = '';
  }

  async function finalizarPagamento() {
    clearMessage();
    clearQRCode();

    if (!selectedPayment) {
      showToast('Por favor, selecione uma forma de pagamento.', true);
      return;
    }

    const total = parseFloat(localStorage.getItem('valorTotalCompra') || "0.00");
    const totalFinal = selectedPayment === 'pix' ? total * 0.95 : total; // Aplica desconto no pix

    if (selectedPayment === 'pix') {
      // Pagamento PIX via fetch
      const formData = new FormData();
      formData.append('total', totalFinal.toFixed(2));

      try {
        const response = await fetch('../controllers/pagamentoPix.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.qr_code_base64) {
          const img = document.createElement('img');
          img.src = 'data:image/png;base64,' + data.qr_code_base64;
          document.getElementById('qr-code-container').appendChild(img);
          document.getElementById('message').innerText = 'PIX gerado com sucesso! Use o QR Code para pagar.';
        } else if(data.erro) {
          document.getElementById('message').innerText = 'Erro: ' + data.erro;
          showToast('Erro ao gerar PIX: ' + data.erro, true);
        } else {
          document.getElementById('message').innerText = 'Erro desconhecido ao gerar PIX.';
          showToast('Erro desconhecido ao gerar PIX.', true);
        }
      } catch (error) {
        document.getElementById('message').innerText = 'Erro na comunicação com o servidor.';
        showToast('Erro na comunicação com o servidor.', true);
        console.error(error);
      }
    }

    if (selectedPayment === 'credit') {
      // Validação simples dos campos
      const numero = document.getElementById('numero-cartao').value.trim();
      const nome = document.getElementById('nome-cartao').value.trim();
      const validade = document.getElementById('validade-cartao').value.trim();
      const cvv = document.getElementById('cvv-cartao').value.trim();
      const cpf = document.getElementById('cpf-cartao').value.trim();
      const parcelas = document.getElementById('parcelas').value;

      if (!numero || !nome || !validade || !cvv || !cpf || !parcelas) {
        showToast('Por favor, preencha todos os campos do cartão.', true);
        return;
      }

      // Simulando token (na prática, você usaria SDK Mercado Pago para gerar token seguro)
      const token = 'fake-token-teste';

      const formData = new FormData();
      formData.append('total', totalFinal.toFixed(2));
      formData.append('parcelas', parcelas);
      formData.append('token', token);
      formData.append('email', 'cliente@email.com'); // Pode pegar do usuário logado

      try {
        const response = await fetch('../controllers/pagamentoCartao.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.status === 'sucesso') {
          document.getElementById('message').innerText = 'Pagamento aprovado! ID: ' + data.id_pagamento;
          showToast('Pagamento aprovado com sucesso!');
        } else if (data.erro) {
          document.getElementById('message').innerText = 'Erro: ' + data.erro;
          showToast('Erro no pagamento: ' + data.erro, true);
        } else {
          document.getElementById('message').innerText = 'Pagamento não aprovado.';
          showToast('Pagamento não aprovado.', true);
        }
      } catch (error) {
        document.getElementById('message').innerText = 'Erro na comunicação com o servidor.';
        showToast('Erro na comunicação com o servidor.', true);
        console.error(error);
      }
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    carregarResumo();
  });

  function showToast(message, isError = false) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: isError ? "#ff4444" : "#4CAF50",
            'border-radius': '4px',
            'box-shadow': '0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)'
        }
    }).showToast();
}

function showRedirectToast(message, target) {
    const toast = Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
            'border-radius': '4px',
            'box-shadow': '0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)'
        },
        onClick: function() {
            window.location.href = target;
        }
    });
    
    toast.showToast();
    
    setTimeout(() => {
        window.location.href = target;
    }, 3000);
}

function showErrorToast(message) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "#ff4444",
            'border-radius': '4px',
            'box-shadow': '0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)'
        }
    }).showToast();
}
</script>

</body>
</html>