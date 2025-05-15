const inputPreco = document.getElementById('preco');
const inputEstoque = document.getElementById('estoque');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('preview-container');
const form = document.getElementById('formProduto');
let imagensSelecionadas = [];

inputPreco.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    if (value === '') return inputPreco.value = 'R$ 0,00';
    value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
    inputPreco.value = 'R$ ' + value;
});

inputEstoque.addEventListener('input', () => {
    inputEstoque.value = inputEstoque.value.replace(/\D/g, '').slice(0, 3);
});

fileInput.addEventListener('change', () => {
    const novosArquivos = Array.from(fileInput.files);
    novosArquivos.forEach(file => {
        if (imagensSelecionadas.length < 3 && file.type.startsWith('image/')) {
            imagensSelecionadas.push(file);
        }
    });
    atualizarPreview();
    fileInput.value = '';
});

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

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    imagensSelecionadas.forEach(imagem => {
        formData.append("produto_imagens[]", imagem);
    });

    fetch("../controllers/cadastroProduto.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.text())
        .then(data => {
            alert("Produto cadastrado com sucesso!");
            setTimeout(() => {
                location.reload(); // recarrega a mesma página
            }, 1000); // 1000 milissegundos = 1 segundo

        })
        .catch(() => alert("Erro ao cadastrar produto!"));
});

document.addEventListener('DOMContentLoaded', function() {
  // Elementos da descrição curta
  const descricaoCurta = document.getElementById('descricao-curta');
  const contadorCurta = document.getElementById('contador-curta');
  
  // Elementos da descrição detalhada
  const descricaoDetalhada = document.getElementById('descricao-detalhada');
  const contadorDetalhada = document.getElementById('contador-detalhada');

  // Atualizar contador da descrição curta
  descricaoCurta.addEventListener('input', function() {
    const caracteresDigitados = this.value.length;
    contadorCurta.textContent = caracteresDigitados;
    
    // Mudar cor se atingir o limite
    contadorCurta.style.color = caracteresDigitados >= 200 ? 'red' : '#666';
  });

  // Atualizar contador da descrição detalhada
  descricaoDetalhada.addEventListener('input', function() {
    const caracteresDigitados = this.value.length;
    contadorDetalhada.textContent = caracteresDigitados;
    
    // Mudar cor se atingir o limite
    contadorDetalhada.style.color = caracteresDigitados >= 300 ? 'red' : '#666';
  });

  // Inicializar contadores
  contadorCurta.textContent = descricaoCurta.value.length;
  contadorDetalhada.textContent = descricaoDetalhada.value.length;
});