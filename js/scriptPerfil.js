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
