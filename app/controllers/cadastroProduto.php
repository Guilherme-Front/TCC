<?php

include_once "conn.php";
$conn->set_charset('utf8mb4');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome_produto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $precoStr = filter_input(INPUT_POST, 'preco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $estoque = filter_input(INPUT_POST, 'estoque', FILTER_SANITIZE_NUMBER_INT);
    $descricaoCurta = filter_input(INPUT_POST, 'descricao_curta', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $preco = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $precoStr));
    $erros = [];

    if (!$nome || !$tipo || !$marca || $preco <= 0 || $estoque < 0 || !$descricaoCurta || !$descricao) {
        $erros[] = "Preencha todos os campos corretamente.";
    }

    if (empty($erros)) {
        $stmt = $conn->prepare("INSERT INTO produto (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $descricaoCurta, $descricao);
        $stmt->execute();
        $produto_id = $conn->insert_id;

        if (isset($_FILES['produto_imagens'])) {
            $total = count($_FILES['produto_imagens']['name']);
            for ($i = 0; $i < $total && $i < 3; $i++) {
                if ($_FILES['produto_imagens']['error'][$i] === 0) {
                    $ext = strtolower(pathinfo($_FILES['produto_imagens']['name'][$i], PATHINFO_EXTENSION));
                    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) continue;

                    $pasta = "../../public/uploads/imgProdutos/$produto_id/";
                    if (!is_dir($pasta)) mkdir($pasta, 0777, true);

                    $nomeUnico = uniqid() . ".$ext";
                    $destino = $pasta . $nomeUnico;

                    if (move_uploaded_file($_FILES['produto_imagens']['tmp_name'][$i], $destino)) {
                        $relativo = "uploads/imgProdutos/$produto_id/$nomeUnico";
                        $stmt_img = $conn->prepare("INSERT INTO imagem_produto (id_produto, nome_imagem) VALUES (?, ?)");
                        $stmt_img->bind_param("is", $produto_id, $relativo);
                        $stmt_img->execute();
                    }
                }
            }
        }
    } else {
        foreach ($erros as $erro) {
            echo "<p style='color:red;'>$erro</p>";
        }
    }
}
?>
