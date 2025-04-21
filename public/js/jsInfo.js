let currentLogin = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;
        const carousel = document.querySelector('.carousel');
        const itemHeight = items[0].clientHeight;

        function moveCarousel() {
            currentLogin++;

            if (currentLogin >= totalItems) {
                currentLogin = 0; // Volta para o primeiro item
            }

            updateCarousel();
        }

        function updateCarousel() {
            const offset = -currentLogin * itemHeight;
            carousel.style.transform = `translateY(${offset}px)`;
        }

        // Roda automaticamente a cada 3 segundos
        setInterval(moveCarousel, 3000);