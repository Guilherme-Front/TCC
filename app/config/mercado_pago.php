<?php
// config.php
require_once __DIR__ . '/vendor/autoload.php';

// Configuração do Mercado Pago
define('MP_ACCESS_TOKEN', 'SEU_ACCESS_TOKEN_AQUI');
define('MP_PUBLIC_KEY', 'SUA_PUBLIC_KEY_AQUI');
define('MP_INTEGRATOR_ID', 'SEU_INTEGRATOR_ID'); // Opcional para parceiros

MercadoPago\SDK::setAccessToken(MP_ACCESS_TOKEN);
MercadoPago\SDK::setIntegratorId(MP_INTEGRATOR_ID);
?>