/* Tempo pra trocar a imagem do Carrosel */

$(".carousel").carousel({
  interval: 2500,
});

document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.getElementById('carousel');
  const slides = document.querySelectorAll('.swiper-slide');
  let scrollAmount = 0;

  if (slides.length > 0) {
    const slideWidth = slides[0].offsetWidth + 20; // Inclui margem/gap entre slides
    const totalWidth = carousel.scrollWidth;
    const visibleWidth = carousel.clientWidth;

    function autoScroll() {
      if (scrollAmount + visibleWidth >= totalWidth) {
        // Retorna ao início suavemente
        carousel.scrollTo({
          left: 0,
          behavior: 'smooth'
        });
        scrollAmount = 0;
      } else {
        // Rola normalmente
        scrollAmount += slideWidth;
        carousel.scrollTo({
          left: scrollAmount,
          behavior: 'smooth'
        });
      }
    }

    setInterval(autoScroll, 3000);
  }
});

function moveCarousel(direction) {
  const carousel = document.getElementById('carousel');
  const slideWidth = document.querySelector('.swiper-slide').offsetWidth + 20;

  if (direction === 'prev') {
    carousel.scrollBy({
      left: -slideWidth,
      behavior: 'smooth'
    });
  } else if (direction === 'next') {
    carousel.scrollBy({
      left: slideWidth,
      behavior: 'smooth'
    });
  }
}