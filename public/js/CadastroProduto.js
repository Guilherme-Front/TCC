const input = document.getElementById('preco');

        input.addEventListener('input', (e) => {
            let value = e.target.value;

            value = value.replace(/\D/g, '');

            if (value === '') {
                input.value = 'R$ 0,00';
                return;
            }

            value = (parseInt(value) / 100).toFixed(2);
            value = value.replace('.', ',');
            value = 'R$ ' + value;

            input.value = value;
        });

        input.value = 'R$ 0,00';

        const estoqueInput = document.getElementById('estoque');

        estoqueInput.addEventListener('input', () => {

            estoqueInput.value = estoqueInput.value.replace(/\D/g, '').slice(0, 3);
        });

        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('preview-container');
        let imagensSelecionadas = [];

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
            const arquivosExistentes = previewContainer.querySelectorAll('.preview-wrapper');
            const totalAtual = arquivosExistentes.length;

            for (let i = totalAtual; i < imagensSelecionadas.length; i++) {
                const file = imagensSelecionadas[i];

                const reader = new FileReader();
                reader.onload = (e) => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('preview-wrapper');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '95px';
                    img.style.height = '95px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '3px';
                    img.style.border = '1px solid #ccc';

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('remove-btn');
                    removeBtn.textContent = 'X';
                    removeBtn.addEventListener('click', () => {
                        imagensSelecionadas.splice(i, 1);
                        previewContainer.removeChild(wrapper);
                        atualizarPreview();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            }
        }