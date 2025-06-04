<?php
// Configurações de encoding - DEVE SER AS PRIMEIRAS LINHAS
header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

include_once "conn.php";

// Função para limpar e decodificar strings
function clean_input($data)
{
    $data = html_entity_decode($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    return trim($data);
}

$response = ['success' => false, 'errors' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determinar se é cadastro ou edição
    $modo = $_POST['modo'] ?? 'cadastro';
    $produto_id = $_POST['id_produto'] ?? null;

    // Processamento dos dados com tratamento especial para UTF-8
    $nome = clean_input($_POST['nome_produto'] ?? '');
    $tipo = clean_input($_POST['tipo'] ?? '');
    $marca = clean_input($_POST['marca'] ?? '');
    $precoStr = str_replace(['R$', ' '], '', $_POST['preco'] ?? '0');
    $estoque = filter_var($_POST['estoque'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
    $descricaoCurta = clean_input($_POST['descricao_curta'] ?? '');
    $descricao = clean_input($_POST['descricao'] ?? '');
    $imagensRemovidas = json_decode($_POST['imagens_removidas'] ?? '[]', true);

    // Formatação do preço
    $preco = floatval(str_replace(',', '.', str_replace('.', '', $precoStr)));

    // Validação comum
    if (empty($nome))
        $response['errors'][] = "Nome do produto é obrigatório";
    if (empty($tipo))
        $response['errors'][] = "Tipo do produto é obrigatório";
    if ($preco <= 0)
        $response['errors'][] = "Preço deve ser maior que zero";
    if ($estoque < 0)
        $response['errors'][] = "Estoque não pode ser negativo";
    if (empty($descricaoCurta))
        $response['errors'][] = "Descrição curta é obrigatória";
    if (empty($descricao))
        $response['errors'][] = "Descrição detalhada é obrigatória";

    // Na parte do código que processa o formulário, modifique a validação:
    if ($modo === 'cadastro' && (!isset($_FILES['produto_imagens']) || count($_FILES['produto_imagens']['name']) === 0)) {
        $response['errors'][] = "Pelo menos uma imagem é obrigatória";
    }

    // Para edição, verifique se há imagens (existentes não removidas ou novas)
    if ($modo === 'edicao') {
        $imagensExistentes = isset($_POST['imagens_existentes']) ? count($_POST['imagens_existentes']) : 0;
        $imagensRemovidas = isset($_POST['imagens_removidas']) ? count($_POST['imagens_removidas']) : 0;
        $novasImagens = isset($_FILES['produto_imagens']) ? count($_FILES['produto_imagens']['name']) : 0;

        // Verifica se todas as imagens existentes foram removidas e nenhuma nova foi adicionada
        if (($imagensExistentes - $imagensRemovidas + $novasImagens) < 1) {
            $response['errors'][] = "O produto deve ter pelo menos uma imagem";
        }
    }

    if (empty($response['errors'])) {
        try {
            if ($modo === 'edicao' && $produto_id) {
                // ATUALIZAÇÃO DE PRODUTO EXISTENTE
                $stmt = $conn->prepare("UPDATE produto SET 
                                      nome_produto = ?, 
                                      tipo = ?, 
                                      marca = ?, 
                                      valor = ?, 
                                      quantidade = ?, 
                                      descricaoMenor = ?, 
                                      descricaoMaior = ? 
                                      WHERE id_produto = ?");
                $stmt->bind_param("sssdissi", $nome, $tipo, $marca, $preco, $estoque, $descricaoCurta, $descricao, $produto_id);

                if ($stmt->execute()) {
                    // Remover imagens marcadas para exclusão
                    if (!empty($imagensRemovidas)) {
                        foreach ($imagensRemovidas as $imagem) {
                            // Remover do banco de dados
                            $stmt_img = $conn->prepare("DELETE FROM imagem_produto WHERE id_produto = ? AND nome_imagem = ?");
                            $stmt_img->bind_param("is", $produto_id, $imagem);
                            $stmt_img->execute();

                            // Remover do servidor
                            $caminhoAbsoluto = realpath("../../public/" . $imagem);
                            if ($caminhoAbsoluto && file_exists($caminhoAbsoluto)) {
                                unlink($caminhoAbsoluto);
                            }
                        }
                    }

                    // Adicionar novas imagens
                    if (isset($_FILES['produto_imagens'])) {
                        $total = count($_FILES['produto_imagens']['name']);
                        for ($i = 0; $i < $total && $i < 3; $i++) {
                            if ($_FILES['produto_imagens']['error'][$i] === 0) {
                                $ext = strtolower(pathinfo($_FILES['produto_imagens']['name'][$i], PATHINFO_EXTENSION));
                                if (!in_array($ext, ['jpg', 'jpeg', 'png']))
                                    continue;

                                $pasta = "../../public/uploads/imgProdutos/$produto_id/";
                                if (!is_dir($pasta))
                                    mkdir($pasta, 0777, true);

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

                    $response['success'] = true;
                    $response['message'] = "Produto atualizado com sucesso!";
                    $response['redirect'] = "../views/telaFuncionario.php#produtos-cadastrados";
                } else {
                    $response['errors'][] = "Erro ao atualizar produto: " . $conn->error;
                }
            } else {
                // CADASTRO DE NOVO PRODUTO
                $stmt = $conn->prepare("INSERT INTO produto (nome_produto, tipo, marca, valor, quantidade, descricaoMenor, descricaoMaior) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssdiss", $nome, $tipo, $marca, $preco, $estoque, $descricaoCurta, $descricao);

                if ($stmt->execute()) {
                    $produto_id = $conn->insert_id;

                    // Processamento de imagens
                    if (isset($_FILES['produto_imagens'])) {
                        $total = count($_FILES['produto_imagens']['name']);
                        for ($i = 0; $i < $total && $i < 3; $i++) {
                            if ($_FILES['produto_imagens']['error'][$i] === 0) {
                                $ext = strtolower(pathinfo($_FILES['produto_imagens']['name'][$i], PATHINFO_EXTENSION));
                                if (!in_array($ext, ['jpg', 'jpeg', 'png']))
                                    continue;

                                $pasta = "../../public/uploads/imgProdutos/$produto_id/";
                                if (!is_dir($pasta))
                                    mkdir($pasta, 0777, true);

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

                    $response['success'] = true;
                    $response['message'] = "Produto cadastrado com sucesso!";
                    $response['redirect'] = "../views/telaFuncionario.php#produtos-cadastrados";
                } else {
                    $response['errors'][] = "Erro ao cadastrar produto: " . $conn->error;
                }
            }
        } catch (Exception $e) {
            $response['errors'][] = "Erro no servidor: " . $e->getMessage();
        }
    }
}

echo json_encode($response);
exit();
?>