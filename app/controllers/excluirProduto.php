<?php
session_start();
require_once __DIR__ . '/../controllers/conn.php';

// Verifica se o funcionário está logado
$id_funcionario = $_SESSION['id_funcionario'] ?? null;
if (!$id_funcionario) {
    header('Location: Login.php');
    exit();
}

// Verifica se o id do produto foi passado por POST
if (!isset($_POST['id_produto']) || empty($_POST['id_produto'])) {
    $_SESSION['toast'] = [
        'message' => 'Produto não especificado.',
        'type' => 'error'
    ];
    header('Location: ../views/telaFuncionario.php#produtos-cadastrados');
    exit();
}

$id_produto = intval($_POST['id_produto']);

// Caminho da pasta do produto
$pastaProduto = __DIR__ . '/../../public/uploads/imgProdutos/' . $id_produto;

// Excluir arquivos da pasta, se existirem
if (is_dir($pastaProduto)) {
    $arquivos = glob($pastaProduto . '/*'); // Pega todos os arquivos da pasta
    foreach ($arquivos as $arquivo) {
        if (is_file($arquivo)) {
            unlink($arquivo); // Exclui cada arquivo
        }
    }
    rmdir($pastaProduto); // Remove a pasta vazia
}

// Excluir imagens do banco
$stmtDelImgs = $conn->prepare("DELETE FROM imagem_produto WHERE id_produto = ?");
$stmtDelImgs->bind_param("i", $id_produto);
$stmtDelImgs->execute();

// Excluir o produto
$stmt = $conn->prepare("DELETE FROM produto WHERE id_produto = ?");
$stmt->bind_param("i", $id_produto);

if ($stmt->execute()) {
    $_SESSION['toast'] = [
        'message' => 'Produto excluído com sucesso!',
        'type' => 'success'
    ];
} else {
    $_SESSION['toast'] = [
        'message' => 'Erro ao excluir o produto: ' . $conn->error,
        'type' => 'error'
    ];
}

header('Location: ../views/telaFuncionario.php#produtos-cadastrados');
exit();
?>
