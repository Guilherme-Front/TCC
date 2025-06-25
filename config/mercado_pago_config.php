<?php
require __DIR__.'/../vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken('TEST-2868464185741237-062316-2874c46d11bdf215e6314aa63b0c920b-1173760382'); // Sandbox ou Produção
MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL); // ambiente de testes
