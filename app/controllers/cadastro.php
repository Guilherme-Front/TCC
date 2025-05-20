<?php
header('Content-Type: application/json; charset=utf-8');
include "../controllers/conn.php";
session_start(); // Adicione esta linha

$response = ['success' => false, 'message' => 'Erro desconhecido'];

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Método não permitido");
    }

    $email = mysqli_real_escape_string($conn, $_POST['Email'] ?? '');
    
    // Verifica e-mail
    $stmt = $conn->prepare("SELECT id_cliente FROM cliente WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        throw new Exception("E-mail já cadastrado!");
    }

    // Armazena os dados na SESSÃO ao invés de inserir no banco
    $_SESSION['cadastro_temp'] = [
        'nome' => mysqli_real_escape_string($conn, $_POST['Nome'] ?? ''),
        'email' => $email,
        'data' => date('Y-m-d', strtotime(str_replace('/', '-', $_POST['Data'] ?? ''))),
        'telefone' => mysqli_real_escape_string($conn, $_POST['Telefone'] ?? '')
    ];

    $response = [
        'success' => true,
        'redirect' => '../views/senha.php'
    ];
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    echo json_encode($response);
    exit();
}
?>