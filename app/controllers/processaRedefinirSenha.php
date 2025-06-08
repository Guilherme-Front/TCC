<?php
session_start();
// No início do arquivo, após session_start()
$_SESSION['codigo_verificacao'] = isset($_SESSION['codigo_verificacao']) ? $_SESSION['codigo_verificacao'] : '';
require '../controllers/conn.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';

// Habilitar logs detalhados para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Logar todo o POST recebido
    error_log("Dados POST recebidos: " . print_r($_POST, true));
    error_log("Dados SESSION atuais: " . print_r($_SESSION, true));

    if (isset($_POST['enviar_codigo'])) {
        $email = trim($_POST['email']);
        if (empty($email)) {
            $response['message'] = "Digite seu e-mail.";
            echo json_encode($response);
            exit;
        }

        // Verifica se o email existe no banco de dados
        $stmt = $conn->prepare("SELECT id_cliente FROM cliente WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $response['message'] = "E-mail não cadastrado.";
            echo json_encode($response);
            exit;
        }

        // Gera código de 6 dígitos e armazena na sessão
        $codigo = strval(rand(100000, 999999)); // Garante que é string
        $_SESSION['codigo_verificacao'] = $codigo;
        $_SESSION['email_verificacao'] = $email;
        $_SESSION['codigo_expira'] = time() + 600; // 10 minutos

        error_log("Código gerado: $codigo para $email, expira em: " . date('Y-m-d H:i:s', $_SESSION['codigo_expira']));

        // Configura e envia o email
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'petinsight.suporte@gmail.com';
            $mail->Password = 'qgmu gqji mvts qrzm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('petinsight.suporte@gmail.com', 'Pet Insight');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Código de verificação - Pet Insight';
            $mail->Body = "
                <h2>Redefinição de Senha</h2>
                <p>Seu código de verificação é: <strong>$codigo</strong></p>
                <p>Este código expira em 10 minutos.</p>
                <p>Caso não tenha solicitado esta redefinição, ignore este e-mail.</p>
            ";
            
            $mail->send();
            error_log("E-mail enviado com sucesso para $email");

            $response['success'] = true;
            $response['message'] = "Código enviado! Verifique seu e-mail.";
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $mail->ErrorInfo);
            $response['message'] = "Erro ao enviar o e-mail. Por favor, tente novamente mais tarde.";
        }
    } 
    elseif (isset($_POST['redefinir_senha'])) {
        $email = trim($_POST['email']);
        $codigo = trim($_POST['codigo']);
        $senha = trim($_POST['novaSenha']);
        $confirmar = trim($_POST['confirmarSenha']);

        // Debug detalhado
        error_log("Tentativa de redefinição - Email: $email, Código: $codigo");
        error_log("Dados na sessão - Código: " . ($_SESSION['codigo_verificacao'] ?? 'NULL') . 
                  ", Email: " . ($_SESSION['email_verificacao'] ?? 'NULL') . 
                  ", Expira: " . (isset($_SESSION['codigo_expira']) ? date('Y-m-d H:i:s', $_SESSION['codigo_expira']) : 'NULL'));

        // Validações
        if (empty($email) || empty($codigo) || empty($senha) || empty($confirmar)) {
            $response['message'] = "Preencha todos os campos.";
        } 
        elseif ($senha !== $confirmar) {
            $response['message'] = "As senhas não coincidem.";
        } 
        elseif (strlen($senha) < 8) {
            $response['message'] = "A senha deve ter no mínimo 8 caracteres.";
        } 
        elseif (
            !isset($_SESSION['codigo_verificacao']) ||
            !isset($_SESSION['email_verificacao']) ||
            !isset($_SESSION['codigo_expira']) ||
            $_SESSION['codigo_verificacao'] !== $codigo || // Comparação direta de strings
            $_SESSION['email_verificacao'] !== $email ||
            time() > $_SESSION['codigo_expira']
        ) {
            $response['message'] = "Código inválido ou expirado. Por favor, solicite um novo código.";
            
            // Debug adicional
            $debugMsg = "Falha na verificação: ";
            if (!isset($_SESSION['codigo_verificacao'])) $debugMsg .= "Código na sessão não definido. ";
            if (!isset($_SESSION['email_verificacao'])) $debugMsg .= "Email na sessão não definido. ";
            if (!isset($_SESSION['codigo_expira'])) $debugMsg .= "Expiração não definida. ";
            if (isset($_SESSION['codigo_verificacao']) && $_SESSION['codigo_verificacao'] !== $codigo) {
                $debugMsg .= "Código não coincide (Sessão: " . $_SESSION['codigo_verificacao'] . " != Recebido: $codigo). ";
            }
            if (isset($_SESSION['email_verificacao']) && $_SESSION['email_verificacao'] !== $email) {
                $debugMsg .= "Email não coincide. ";
            }
            if (isset($_SESSION['codigo_expira']) && time() > $_SESSION['codigo_expira']) {
                $debugMsg .= "Código expirado. ";
            }
            
            error_log($debugMsg);
        } 
        else {
            // Verifica se o email existe
            $stmt = $conn->prepare("SELECT id_cliente FROM cliente WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $cliente = $result->fetch_assoc();

            if (!$cliente) {
                $response['message'] = "E-mail não cadastrado.";
            } else {
                $id_cliente = $cliente['id_cliente'];
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                // Verifica se já existe uma senha para este cliente
                $stmt = $conn->prepare("SELECT id_senha FROM senha WHERE id_cliente = ?");
                $stmt->bind_param("i", $id_cliente);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $stmt = $conn->prepare("UPDATE senha SET senha = ? WHERE id_cliente = ?");
                    $stmt->bind_param("si", $senhaHash, $id_cliente);
                } else {
                    $stmt = $conn->prepare("INSERT INTO senha (id_cliente, senha) VALUES (?, ?)");
                    $stmt->bind_param("is", $id_cliente, $senhaHash);
                }

                if ($stmt->execute()) {
                    // Limpa a sessão após sucesso
                    unset($_SESSION['codigo_verificacao']);
                    unset($_SESSION['email_verificacao']);
                    unset($_SESSION['codigo_expira']);
                    
                    error_log("Senha redefinida com sucesso para $email");
                    
                    $response['success'] = true;
                    $response['message'] = "Senha redefinida com sucesso! Redirecionando...";
                } else {
                    error_log("Erro ao atualizar senha no banco de dados: " . $conn->error);
                    $response['message'] = "Erro ao atualizar a senha. Por favor, tente novamente.";
                }
            }
        }
    }
    else {
        $response['message'] = "Ação inválida.";
    }
} else {
    $response['message'] = "Método de requisição inválido.";
}

error_log("Resposta enviada: " . print_r($response, true));
echo json_encode($response);
exit;