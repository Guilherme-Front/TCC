
<?php
// public/loginFacebook.php

// 1) Carrega as constantes e o Composer
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

// 2) Inicia o SDK do Facebook
$fb = new \Facebook\Facebook([
    'app_id'                => FACEBOOK_APP_ID,
    'app_secret'            => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v18.0',
]);

// 3) Gera o URL de login
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // permissões que você precisar
$callbackUrl = 'http://localhost/TCC/public/fb-callback.php'; // ajuste conforme seu domínio/virtual host
$loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);

// 4) Exibe o link de login
echo '<a href="' . htmlspecialchars($loginUrl) . '">Login com Facebook</a>';