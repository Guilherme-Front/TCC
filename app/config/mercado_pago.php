<?php
require_once __DIR__ . '/../vendor/autoload.php';

return [
    'public_key' => 'APP_USR-a5a070ce-2b4d-4728-a137-917c5416df17',
    'access_token' => 'APP_USR-6594873367631176-060514-a15b25595c4a02ee1ce4ea7babe32f64-1173760382',
    'sandbox' => true, // Modo de teste
    'notification_url' => 'https://seusite.com/api/notificacoes',
    'back_urls' => [
        'success' => 'https://seusite.com/pagamento/sucesso',
        'failure' => 'https://seusite.com/pagamento/erro',
        'pending' => 'https://seusite.com/pagamento/pendente'
    ]
];