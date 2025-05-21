<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    $_SESSION['toast'] = [
        'message' => 'Você precisa estar logado para acessar esta página!',
        'type' => 'error'
    ];
    header('Location: ../views/Login.php');
    exit();
}

// Verifica o token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['toast'] = [
        'message' => 'Token de segurança inválido!',
        'type' => 'error'
    ];
    header('Location: ../views/telaPerfil.php#endereco-section');
    exit();
}

// Função para limpar e validar dados
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Função para validar e formatar CEP
function validarCEP($cep)
{
    // Remove todos os caracteres não numéricos
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Verifica se tem 8 dígitos
    if (strlen($cep) !== 8) {
        return false;
    }

    return $cep;
}

// Processa os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_SESSION['id_cliente'];
    $cep = validarCEP($_POST['cep']); // Usa a nova função de validação
    $rua = sanitizeInput($_POST['rua']);
    $bairro = sanitizeInput($_POST['bairro']);
    $cidade = sanitizeInput($_POST['cidade']);
    $numero = isset($_POST['numero']) ? (int) sanitizeInput($_POST['numero']) : null;
    $complemento = isset($_POST['complemento']) ? sanitizeInput($_POST['complemento']) : null;

    // Validações básicas
    $erros = [];

    if ($cep === false) {
        $erros[] = 'CEP deve conter exatamente 8 dígitos.';
    }

    if (empty($rua)) {
        $erros[] = 'Rua é obrigatória.';
    } elseif (strlen($rua) < 3) {
        $erros[] = 'Rua deve ter pelo menos 3 caracteres.';
    }

    if (empty($bairro)) {
        $erros[] = 'Bairro é obrigatório.';
    }

    if (empty($cidade)) {
        $erros[] = 'Cidade é obrigatória.';
    }

    if ($numero !== null && ($numero < 1 || $numero > 9999)) {
        $erros[] = 'Número deve estar entre 1 e 9999.';
    }

    // Se não houver erros, busca o endereço pelo CEP
    if (empty($erros)) {
        $dadosCEP = buscarEnderecoPorCEP($cep);

        if (isset($dadosCEP['erro'])) {
            $erros[] = 'CEP não encontrado. Verifique o número digitado.';
        } else {
            // Preenche automaticamente apenas se os campos estiverem vazios
            if (empty($rua))
                $rua = $dadosCEP['logradouro'] ?? '';
            if (empty($bairro))
                $bairro = $dadosCEP['bairro'] ?? '';
            if (empty($cidade))
                $cidade = $dadosCEP['localidade'] ?? '';

            // Verifica novamente os campos obrigatórios
            if (empty($rua))
                $erros[] = 'Não foi possível obter o logradouro deste CEP. Por favor, preencha manualmente.';
            if (empty($bairro))
                $erros[] = 'Não foi possível obter o bairro deste CEP. Por favor, preencha manualmente.';
            if (empty($cidade))
                $erros[] = 'Não foi possível obter a cidade deste CEP. Por favor, preencha manualmente.';
        }
    }

    // Se houver erros, retorna para a página com mensagens
    if (!empty($erros)) {
        $_SESSION['toast'] = [
            'message' => implode(' • ', $erros), // Usa bullet points para separar os erros
            'type' => 'error'
        ];
        $_SESSION['dados_endereco'] = $_POST; // Mantém os dados digitados
        header('Location: ../views/telaPerfil.php#endereco-section');
        exit();
    }

    try {
        // Verifica se já existe um endereço para este cliente
        $stmt = $conn->prepare("SELECT id_endereco FROM endereco WHERE id_cliente = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Atualiza o endereço existente
            $row = $result->fetch_assoc();
            $id_endereco = $row['id_endereco'];

            $stmt = $conn->prepare("UPDATE endereco SET 
                                  cep = ?, 
                                  bairro = ?, 
                                  rua = ?, 
                                  cidade = ?, 
                                  complemento = ?, 
                                  numero = ? 
                                  WHERE id_endereco = ?");
            $stmt->bind_param("sssssii", $cep, $bairro, $rua, $cidade, $complemento, $numero, $id_endereco);

            $acao = 'atualizado';
        } else {
            // Insere um novo endereço
            $stmt = $conn->prepare("INSERT INTO endereco 
                                  (id_cliente, cep, bairro, rua, cidade, complemento, numero) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssi", $id_cliente, $cep, $bairro, $rua, $cidade, $complemento, $numero);

            $acao = 'cadastrado';
        }

        if ($stmt->execute()) {
            $_SESSION['toast'] = [
                'message' => 'Endereço ' . $acao . ' com sucesso! 🎉',
                'type' => 'success'
            ];
        } else {
            throw new Exception('Erro ao salvar endereço no banco de dados.');
        }
    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'message' => 'Erro: ' . $e->getMessage(),
            'type' => 'error'
        ];
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }

    header('Location: ../views/telaPerfil.php#endereco-section');
    exit();
} else {
    $_SESSION['toast'] = [
        'message' => 'Método de requisição inválido!',
        'type' => 'error'
    ];
    header('Location: ../views/telaPerfil.php');
    exit();
}

function buscarEnderecoPorCEP($cep)
{
    $url = "https://viacep.com.br/ws/{$cep}/json/";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}