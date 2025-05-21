const inputPreco = document.getElementById('preco');
const inputEstoque = document.getElementById('estoque');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('preview-container');
const form = document.getElementById('formProduto');
let imagensSelecionadas = [];

// Formatação do preço
inputPreco.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    if (value === '') return inputPreco.value = 'R$ 0,00';
    value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
    inputPreco.value = 'R$ ' + value;
});

// Validação do estoque (apenas números)
inputEstoque.addEventListener('input', () => {
    inputEstoque.value = inputEstoque.value.replace(/\D/g, '').slice(0, 3);
});

// Gerenciamento de imagens
fileInput.addEventListener('change', () => {
    const novosArquivos = Array.from(fileInput.files);
    const tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    
    novosArquivos.forEach(file => {
        if (imagensSelecionadas.length < 3 && tiposPermitidos.includes(file.type)) {
            imagensSelecionadas.push(file);
        } else if (!tiposPermitidos.includes(file.type)) {
            error(`Tipo de arquivo não suportado: ${file.name}`, "linear-gradient(to right, #cd1809, #a01006)");
        }
    });
    
    if (novosArquivos.length > 3) {
        error("Máximo de 3 imagens permitidas", "linear-gradient(to right, #cd1809, #a01006)");
    }
    
    atualizarPreview();
    fileInput.value = '';
});

// Atualiza a visualização das imagens
function atualizarPreview() {
    previewContainer.innerHTML = '';
    imagensSelecionadas.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('preview-wrapper');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '95px';
            img.style.height = '95px';
            img.style.objectFit = 'cover';
            img.style.border = '1px solid #ccc';

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'X';
            removeBtn.classList.add('remove-btn');
            removeBtn.onclick = () => {
                imagensSelecionadas.splice(i, 1);
                atualizarPreview();
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

// Contadores de caracteres para descrições
document.addEventListener('DOMContentLoaded', function() {
    const descricaoCurta = document.getElementById('descricao-curta');
    const contadorCurta = document.getElementById('contador-curta');
    const descricaoDetalhada = document.getElementById('descricao-detalhada');
    const contadorDetalhada = document.getElementById('contador-detalhada');

    descricaoCurta.addEventListener('input', function() {
        const caracteresDigitados = this.value.length;
        contadorCurta.textContent = caracteresDigitados;
        contadorCurta.style.color = caracteresDigitados >= 200 ? 'red' : '#666';
    });

    descricaoDetalhada.addEventListener('input', function() {
        const caracteresDigitados = this.value.length;
        contadorDetalhada.textContent = caracteresDigitados;
        contadorDetalhada.style.color = caracteresDigitados >= 500 ? 'red' : '#666';
    });

    // Inicializar contadores
    contadorCurta.textContent = descricaoCurta.value.length;
    contadorDetalhada.textContent = descricaoDetalhada.value.length;
});

// Validação do formulário antes de enviar
function validarFormulario() {
    let valido = true;
    
    if (imagensSelecionadas.length === 0) {
        error("Pelo menos uma imagem é obrigatória", "linear-gradient(to right, #cd1809, #a01006)");
        valido = false;
    }
    
    // Validação adicional pode ser adicionada aqui
    
    return valido;
}

// Envio do formulário
form.addEventListener("submit", function (e) {
    e.preventDefault();
    
    if (!validarFormulario()) {
        return;
    }

    // Feedback visual durante o envio
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.textContent;
    submitButton.textContent = "Cadastrando...";
    submitButton.disabled = true;

    const formData = new FormData(form);
    imagensSelecionadas.forEach(imagem => {
        formData.append("produto_imagens[]", imagem);
    });

    fetch("../controllers/cadastroProduto.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na resposta do servidor', "linear-gradient(to right, #cd1809, #a01006)");
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            redirection(data.message || "Produto cadastrado com sucesso!", "linear-gradient(to right, #00b09b, #96c93d)");
            
            // Limpar formulário após sucesso
            form.reset();
            imagensSelecionadas = [];
            atualizarPreview();
            
            // Redirecionar após 3 segundos
            setTimeout(() => {
                window.location.href = "Index.php";
            }, 3000);
        } else {
            if (data.errors && data.errors.length > 0) {
                data.errors.forEach(erro => {
                    error(erro);
                });
            } else {
                error("Erro ao cadastrar produto", "linear-gradient(to right, #cd1809, #a01006)");
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        error("Erro ao conectar com o servidor", "linear-gradient(to right, #cd1809, #a01006)");
    })
    .finally(() => {
        // Restaurar botão
        submitButton.textContent = originalButtonText;
        submitButton.disabled = false;
    });
});

// Função para mostrar notificações
function redirection(message, target) {
    Toastify({
        text: message,
        close: true,
        gravity: "top", // `top` ou `bottom`
        position: "right", // `left`, `center` ou `right`
        stopOnFocus: true, // Impede o fechamento ao passar o mouse
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () { } // Callback após clicar
    }).showToast();

    // Redireciona após o tempo do toast
    setTimeout(() => {
        window.location.href = target;
    }, 3500); // Tempo em milissegundos
}

function error(message, color) {
    Toastify({
        text: message,
        duration: 3500,
        close: true,
        gravity: "top", // `top` ou `bottom`
        position: "right", // `left`, `center` ou `right`
        stopOnFocus: true, // Impede o fechamento ao passar o mouse
        style: {
            background: color,
        },
        onClick: function () { }
    }).showToast();
}