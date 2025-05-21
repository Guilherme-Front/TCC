<?php
// Configurações de encoding - DEVE SER AS PRIMEIRAS LINHAS
header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include_once "conn.php";

// Função para limpar e decodificar strings
function clean_input($data) {
    $data = html_entity_decode($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    return trim($data);
}

$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processamento dos dados com tratamento especial para UTF-8
    $nome = clean_input($_POST['nome_produto'] ?? '');
    $tipo = clean_input($_POST['tipo'] ?? '');
    $marca = clean_input($_POST['marca'] ?? '');
    $precoStr = str_replace(['R$', ' '], '', $_POST['preco'] ?? '0');
    $estoque = filter_var($_POST['estoque'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $descricaoCurta = clean_input($_POST['descricao_curta'] ?? '');
    $descricao = clean_input($_POST['descricao'] ?? '');

    // Formatação do preço
    $preco = floatval(str_replace(',', '.', str_replace('.', '', $precoStr)));
    
    // Validação
    if (empty($nome)) $response['errors'][] = "Nome do produto é obrigatório";
    if (empty($tipo)) $response['errors'][] = "Tipo do produto é obrigatório";
    if ($preco <= 0) $response['errors'][] = "Preço deve ser maior que zero";
    if ($estoque < 0) $response['errors'][] = "Estoque não pode ser negativo";
    if (empty($descricaoCurta)) $response['errors'][] = "Descrição curta é obrigatória";
    if (empty($descricao)) $response['errors'][] = "Descrição detalhada é obrigatória";

    // Validação de imagens
    if (!isset($_FILES['produto_imagens']) || count($_FILES['produto_imagens']['name']) === 0) {
        $response['errors'][] = "Pelo menos uma imagem é obrigatória";
    }

    if (empty($response['errors'])) {
        try {
            // Inserção no banco de dados
            $stmt = $conn->prepare("INSERT INTO produto (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $descricaoCurta, $descricao);
            
            if ($stmt->execute()) {
                $produto_id = $conn->insert_id;
                $response['success'] = true;
                $response['message'] = "Produto cadastrado com sucesso!";
                
                // Processamento de imagens
                if (isset($_FILES['produto_imagens'])) {
                    $total = count($_FILES['produto_imagens']['name']);
                    for ($i = 0; $i < $total && $i < 3; $i++) {
                        if ($_FILES['produto_imagens']['error'][$i] === 0) {
                            $ext = strtolower(pathinfo($_FILES['produto_imagens']['name'][$i], PATHINFO_EXTENSION));
                            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) continue;

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
                $response['errors'][] = "Erro ao cadastrar produto: " . $conn->error;
            }
        } catch (Exception $e) {
            $response['errors'][] = "Erro no servidor: " . $e->getMessage();
        }
    }
}

echo json_encode($response);
exit();
?>