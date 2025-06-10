<?php
session_start();
require '../controllers/conn.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';

header('Content-Type: application/json'); // Add this line

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Enhanced validation
    if (empty($nome) || empty($email) || empty($mensagem)) {
        echo json_encode([
            'success' => false,
            'message' => "Por favor, preencha todos os campos."
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => "Por favor, insira um e-mail válido."
        ]);
        exit;
    }

    $domain = explode('@', $email)[1] ?? '';
    if (!checkdnsrr($domain, 'MX')) {
        echo json_encode([
            'success' => false,
            'message' => "Domínio de e-mail inválido."
        ]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'petinsight.suporte@gmail.com';
        $mail->Password = 'bvvp qkkx lhqh ieya';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('petinsight.suporte@gmail.com', 'Pet Insight Site');
        $mail->addAddress('petinsight.suporte@gmail.com', 'Suporte Pet Insight');
        $mail->addReplyTo($email, $nome);

        $mail->isHTML(true);
        $mail->Subject = "Mensagem de contato de $nome";
        $mail->Body = "

        <h2>Nova mensagem recebida</h2>
        <p><strong>De:</strong> $nome &lt;$email&gt;</p>
        <p><strong>Data:</strong> " . date('d/m/Y H:i') . "</p>
        <p><strong>Mensagem:</strong></p>
        <div style='background:#f5f5f5; padding:15px; border-radius:5px; margin-bottom:20px;'>
        " . nl2br(htmlspecialchars($mensagem)) . "
        </div>
        <div style='font-size:12px; color:#666; border-top:1px solid #eee; padding-top:10px;'>
            Esta mensagem foi enviada através do formulário de contato do site <strong>Pet Insight</strong>.
            <br>Não responda diretamente este e-mail - utilize o endereço do remetente acima.
        </div>
        ";

        $mail->AltBody = "Mensagem de $nome ($email):\n\n$mensagem\n\n"
            . "Enviada em " . date('d/m/Y H:i') . " através do formulário de contato do site Pet Insight.\n"
            . "Não responda diretamente este e-mail - utilize o endereço do remetente acima.";


        $mail->AltBody = "Mensagem de $nome ($email):\n\n$mensagem\n\nEnviada em " . date('d/m/Y H:i');

        if (!$mail->send()) {
            throw new Exception('Erro ao enviar: ' . $mail->ErrorInfo);
        }

        echo json_encode([
            'success' => true,
            'message' => "Mensagem enviada com sucesso!"
        ]);
        exit;

    } catch (Exception $e) {
        error_log("Email sending error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => "Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente mais tarde."
        ]);
        exit;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Método de requisição inválido."
    ]);
    exit;
}