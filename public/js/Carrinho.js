function alterarQuantidade(botao, valor) {
    let input = botao.closest('.pedido').querySelector('.quantidade-produto');
    let quantidade = parseInt(input.value) + valor;
    if (quantidade >= 1) {
        input.value = quantidade;
    }
}