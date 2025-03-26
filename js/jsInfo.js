let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;
        const carousel = document.querySelector('.carousel');
        const itemHeight = items[0].clientHeight;

        function moveCarousel() {
            currentIndex++;

            if (currentIndex >= totalItems) {
                currentIndex = 0; // Volta para o primeiro item
            }

            updateCarousel();
        }

        function updateCarousel() {
            const offset = -currentIndex * itemHeight;
            carousel.style.transform = `translateY(${offset}px)`;
        }

        // Roda automaticamente a cada 3 segundos
        setInterval(moveCarousel, 3000);