<?php
// public/fb-callback.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

$fb = new \Facebook\Facebook([
    'app_id'                => FACEBOOK_APP_ID,
    'app_secret'            => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v18.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (!isset($accessToken)) {
    echo 'Erro: não foi possível obter o token de acesso.';
    exit;
}

// Pega dados do usuário
$response = $fb->get('/me?fields=id,name,email', $accessToken);
$user = $response->getGraphUser();

// Armazena na sessão e redireciona
$_SESSION['user_name']  = $user->getName();
$_SESSION['user_email'] = $user->getEmail();

header('Location: dashboard.php');
exit();