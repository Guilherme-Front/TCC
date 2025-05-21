var menuLateral = document.querySelector('.menu-lateral');

menuLateral.addEventListener('mouseover', function () {
  menuLateral.classList.add('expandir');
});

menuLateral.addEventListener('mouseout', function () {
  menuLateral.classList.remove('expandir');
});

var menuItem = document.querySelectorAll('.item-menu');

function selectLink() {
  menuItem.forEach((item) => item.classList.remove('ativo'));
  this.classList.add('ativo');
}

menuItem.forEach((item) => item.addEventListener('click', selectLink));

const menu = document.querySelector(".menu-lateral");
const body = document.body;

if (window.innerWidth <= 400) {
  // Clica no ícone do menu para abrir
  menu.addEventListener("click", (e) => {
    // Impede o clique de propagar para o body
    e.stopPropagation();
    body.classList.add("menu-expandido");
  });

  // Clica em qualquer lugar fora do menu = fecha
  document.addEventListener("click", () => {
    body.classList.remove("menu-expandido");
  });

  // Impede que cliques dentro do menu fechem ele
  menu.addEventListener("click", (e) => e.stopPropagation());
}

function redirection(message, target) {
    Toastify({
        text: message,
        duration: 3500,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
            borderRadius: "4px",
            boxShadow: "0 4px 8px rgba(0,0,0,0.1)",
            fontSize: "14px"
        },
        onClick: function() {}
    }).showToast();

    setTimeout(() => {
        window.location.href = target;
    }, 3500);
}

function showToast(message, type) {
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
        },
        onClick: function() {}
    }).showToast();
}

// Função mantida para compatibilidade
function error(message, color) {
    showToast(message, 'error');
}

// Função para exibir mensagens de validação
function showValidationError(message, elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        const errorElement = document.createElement('div');
        errorElement.className = 'validation-error';
        errorElement.textContent = message;
        errorElement.style.color = '#ff5f6d';
        errorElement.style.fontSize = '12px';
        errorElement.style.marginTop = '5px';
        
        // Remove mensagens anteriores
        const existingError = element.parentNode.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
        
        element.parentNode.appendChild(errorElement);
    }
}