const button = document.querySelector('.faq-question');
const message = document.querySelector('.faq-message');

// Adiciona um evento de clique no botão
button.addEventListener('click', () => {
    // Alterna a visibilidade da mensagem
    if (message.style.display === 'none') {
        message.style.display = 'block'; // Mostra a mensagem
    } else {
        message.style.display = 'none'; // Oculta a mensagem
    }
});

// Captura o botão e a mensagem
const buttons = document.querySelectorAll('.faq-questions');
const messages = document.querySelectorAll('.faq-messages');

// Adiciona eventos de clique em cada botão
buttons.forEach((buttons, index) => {
    buttons.addEventListener('click', () => {
        const msg = messages[index]; // Obtem a mensagem correspondente pelo índice
        // Alterna a visibilidade da mensagem
        if (msg.style.display === 'none' || !msg.style.display) {
            msg.style.display = 'block'; // Mostra a mensagem
        } else {
            msg.style.display = 'none'; // Oculta a mensagem
        }
    });
});

/* Função Receber Email */

emailjs.init("AQn0UgTvuGxlCOA0N");

document.getElementById("contactForm").addEventListener("submit", function(event) { 
    event.preventDefault(); // Evita que a página recarregue

    // Envia o e-mail usando EmailJS
    emailjs.send("service_6zyhita", "template_74r4ni8", {
        to_name: "Guilherme Farias",
        from_name: document.getElementById("nome").value,
        from_email: document.getElementById("email").value,
        reply_to: document.getElementById("email").value,
        message: document.getElementById("mensagem").value
    }).then(response => {
        alert("Sua dúvida foi enviada com sucesso!");
    }).catch(error => {
        alert("Erro ao enviar: " + error);
    });
});


