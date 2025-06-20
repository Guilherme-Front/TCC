<?php

// Configuração inicial
require_once __DIR__.'/../app/config/mercado_pago.php';
require_once __DIR__.'/../vendor/autoload.php';

// Conexão com o banco de dados
$db = new PDO('mysql:host=localhost;dbname=seu_banco', 'usuario', 'senha');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Inicializar controladores
$pagamentoController = new PagamentoController($db);

// Roteamento
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($path) {
    case '/checkout':
        if (isset($_GET['pedido_id'])) {
            $pagamentoController->iniciarCheckout((int)$_GET['pedido_id']);
        } elseif (isset($_GET['preference_id'])) {
            $pagamentoController->exibirCheckout($_GET['preference_id']);
        } else {
            header('Location: /carrinho');
            exit;
        }
        break;
        
    case '/pagamento/sucesso':
        $pagamentoController->sucesso($_GET['payment_id'] ?? '');
        break;
        
    case '/pagamento/erro':
        $pagamentoController->erro(
            $_GET['message'] ?? 'Erro no pagamento',
            $_GET['error_code'] ?? null,
            $_GET['pedido_id'] ?? null
        );
        break;
        
    case '/api/notificacoes':
        $pagamentoController->processarNotificacao();
        break;
        
    case '/api/criar-pedido':
        // Implementar lógica para criar pedido
        break;
        
    default:
        // Seu roteamento padrão
        break;
}