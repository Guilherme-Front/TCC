<?php
// Configurações de encoding - DEVE SER AS PRIMEIRAS LINHAS
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include_once "conn.php";

// Função para limpar e decodificar strings
function clean_input($data) {
    $data = html_entity_decode($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    return trim($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DEBUG: Registrar dados recebidos
    error_log("Dados recebidos RAW: " . print_r($_POST, true));
    
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
    $erros = [];
    if (empty($nome)) $erros[] = "Nome do produto é obrigatório";
    if (empty($tipo)) $erros[] = "Tipo do produto é obrigatório";
    if ($preco <= 0) $erros[] = "Preço deve ser maior que zero";
    if ($estoque < 0) $erros[] = "Estoque não pode ser negativo";

    if (empty($erros)) {
        // Inserção no banco de dados com tratamento UTF-8
        $stmt = $conn->prepare("INSERT INTO produto (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $descricaoCurta, $descricao);
        
        if ($stmt->execute()) {
            $produto_id = $conn->insert_id;
            
            // Processamento de imagens (mantido como original)
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
            
            // Redirecionamento após sucesso
            header("Location: lista_produtos.php?sucesso=1");
            exit();
        } else {
            $erros[] = "Erro ao cadastrar produto: " . $conn->error;
        }
    }
    
    // Tratamento de erros
    if (!empty($erros)) {
        session_start();
        $_SESSION['erros_cadastro'] = $erros;
        $_SESSION['dados_formulario'] = $_POST;
        header("Location: cadastro_produto.php?erro=1");
        exit();
    }
}
?>