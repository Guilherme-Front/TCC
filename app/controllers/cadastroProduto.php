<?php

session_start();

include_once "../controllers/conn.php";

// Receber dados do formulário
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Acessar if quando clicar no botão de cadastrar
if (!empty($dados['enviar-dados'])) {
    var_dump($dados);

    // Converter preço BRL para float
    $preco_formatado = str_replace(['R$', '.', ','], ['', '', '.'], $preco_br);
    $preco = floatval($preco_formatado);
    // Cadastrar produto no banco de dados
    $query_produto = "INSERT INTO produto (nome_produto, tipo, desricaoMenor, descricaoMaior, valor, quantidade, marca) VALUES (:nome_produto, :tipo, :descricao_curta, :descricao_detalhada, :preco, :estoque, :marca)";

    // Preparar QUERY
    $cad_produto = $conn->prepare($query_produto);

    // Substituir links pelo valor do formulário
    $cad_produto->bind_Param(':nome_produto', $dados['nome_produto']);
    $cad_produto->bind_Param(':tipo', $dados['tipo']);
    $cad_produto->bind_Param(':descricao_curta', $dados['descricao_curta']);
    $cad_produto->bind_Param(':descricao_detalhada', $dados['descricao_detalhada']);
    $cad_produto->bind_Param(':preco', $dados['preco']);
    $cad_produto->bind_Param(':estoque', $dados['estoque']);
    $cad_produto->bind_Param(':marca', $dados['marca']);

    // Executar QUERY
    $cad_produto->execute();

    if ($cad_produto->rowCount()) {
        $_SESSION['msg'] = "<p>Produto cadastrado<p>";
    } else {
        $_SESSION['msg'] = "<p>Erro: não foi possível cadastrar o produto<p>";
    }
}

?>