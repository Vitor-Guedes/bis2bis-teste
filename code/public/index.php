<?php

use App\App;
use App\Http\Response;
use App\Http\ResponseCode;

define('BASEDIR', dirname(__DIR__));

include_once BASEDIR . "/vendor/autoload.php";

try {
    $app = new App();

    include_once BASEDIR . '/config/services.php';
    
    include_once BASEDIR . '/config/routes.php';

    $app->run();
} catch (Exception $e) {
    $response = new Response();
    $response->setBody($e->getMessage(), ResponseCode::INTERNAL_ERROR);
    $response->send();
} 