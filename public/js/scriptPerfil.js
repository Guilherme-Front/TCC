var menuLateral = document.querySelector('.menu-lateral');

menuLateral.addEventListener('mouseover', function() {
    menuLateral.classList.add('expandir'); 
});

menuLateral.addEventListener('mouseout', function() {
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