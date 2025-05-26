// Configuração do Menu Lateral (funciona para .menu-lateral e .menu-lateral-fn)
function setupMenuLateral() {
  // Tenta encontrar qualquer um dos menus
  const menuLateral = document.querySelector('.menu-lateral, .menu-lateral-fn');
  
  if (!menuLateral) return; // Se não encontrar nenhum, encerra

  // Animação hover (expandir/retrair)
  menuLateral.addEventListener('mouseover', function() {
    this.classList.add('expandir');
  });

  menuLateral.addEventListener('mouseout', function() {
    this.classList.remove('expandir');
  });

  // Seleção de itens do menu
  const menuItems = menuLateral.querySelectorAll('.item-menu');

  function selectLink() {
    menuItems.forEach((item) => item.classList.remove('ativo'));
    this.classList.add('ativo');
  }

  menuItems.forEach((item) => item.addEventListener('click', selectLink));

  // Comportamento para mobile (telas pequenas)
  const body = document.body;

  if (window.innerWidth <= 400) {
    // Clica no menu para abrir
    menuLateral.addEventListener("click", (e) => {
      e.stopPropagation();
      body.classList.add("menu-expandido");
    });

    // Clica fora do menu para fechar
    document.addEventListener("click", () => {
      body.classList.remove("menu-expandido");
    });

    // Impede que cliques dentro do menu fechem-no
    menuLateral.addEventListener("click", (e) => e.stopPropagation());
  }
}

// Toast e Redirecionamento (genéricos, podem ser usados em qualquer página)
function showToast(message, type = 'success') {
  Toastify({
    text: message,
    duration: 3500,
    close: true,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    style: {
      background: type === 'success' 
        ? "linear-gradient(to right, #00b09b, #96c93d)" 
        : "linear-gradient(to right, #ff5f6d, #ffc371)",
      borderRadius: "4px",
      boxShadow: "0 4px 8px rgba(0,0,0,0.1)",
      fontSize: "14px"
    }
  }).showToast();
}

function redirection(message, target) {
  showToast(message);
  setTimeout(() => { window.location.href = target; }, 3500);
}

function showValidationError(message, elementId) {
  const element = document.getElementById(elementId);
  if (!element) return;

  // Remove erros anteriores
  const existingError = element.parentNode.querySelector('.validation-error');
  if (existingError) existingError.remove();

  // Cria novo erro
  const errorElement = document.createElement('div');
  errorElement.className = 'validation-error';
  errorElement.textContent = message;
  errorElement.style.cssText = `
    color: #ff5f6d;
    font-size: 12px;
    margin-top: 5px;
  `;
  
  element.parentNode.appendChild(errorElement);
}

// Inicializa o menu quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', setupMenuLateral);