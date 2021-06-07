<?php

use App\Kernel;
use App\LegacyBridge;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$scriptFile = LegacyBridge::prepareLegacyScript($request, $response, __DIR__);
if ($scriptFile !== null) {
    require $scriptFile;
} else {
    $response->send();
}

$kernel->terminate($request, $response);
