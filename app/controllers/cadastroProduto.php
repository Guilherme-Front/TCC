<?php
include_once "../controllers/conn.php";

// 1) Garante UTF-8
$conn->set_charset('utf8mb4');

if (isset($_POST['enviar-dados'])) {
    // 2) Coleta e saneamento
    $nomeProduto = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipoRaw = filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $preco = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);
    $descricaoCurta = filter_input(INPUT_POST, 'descricao_curta', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricaoDetalhada = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $arquivo = $_FILES['produto_imagens'];

    // 3) Validação e normalização do tipo
    $tiposValidos = ['Rações', 'Aperitivos', 'Coleiras', 'Brinquedos', 'Higiene'];
    $tipoTrim = trim($tipoRaw);
    $tipoLower = mb_strtolower($tipoTrim, 'UTF-8');
    $tiposValidosLower = array_map(fn($v) => mb_strtolower($v, 'UTF-8'), $tiposValidos);
    $idx = array_search($tipoLower, $tiposValidosLower, true);

    $erros = [];

    if ($idx === false) {
        $erros[] = "O tipo selecionado é inválido.";
    } else {
        $tipo = $tiposValidos[$idx];
    }

    // 4) Validação dos outros campos
    if ($nomeProduto === '') $erros[] = "O nome do produto é obrigatório.";
    if ($marca === '') $erros[] = "A marca do produto é obrigatória.";
    if ($preco === false || $preco === null) $erros[] = "O preço do produto é inválido.";
    if ($estoque === false || $estoque === null || $estoque < 0) $erros[] = "O estoque do produto é inválido.";
    if ($descricaoCurta === '') $erros[] = "A descrição curta é obrigatória.";
    if ($descricaoDetalhada === '') $erros[] = "A descrição detalhada é obrigatória.";

    // 5) Se não houver erros, insere produto
    if (empty($erros)) {
        // 5.1) Inserir produto
        $sql = "INSERT INTO produto
                    (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior)
                VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("<p style='color:red;'>Erro no prepare(): " . $conn->error . "</p>");
        }

        $stmt->bind_param(
            "sssdiss",
            $nomeProduto,
            $tipo,
            $marca,
            $preco,
            $estoque,
            $descricaoCurta,
            $descricaoDetalhada
        );

        if (!$stmt->execute()) {
            die("<p style='color:red;'>Erro no execute(): " . $stmt->error . "</p>");
        }

        echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>";


    } else {
        foreach ($erros as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
    }
      
}
?>
