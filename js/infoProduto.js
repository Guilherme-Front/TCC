
function alterarQuantidade(valor) {
    let input = document.getElementById("quantidade");
    let quantidade = parseInt(input.value) + valor;
    if (quantidade >= 1) {
        input.value = quantidade;
    }
}

