<?php

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once __DIR__.'./../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = \DI\Bridge\Slim\Bridge::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('potara.org');
    return $response;
});

$app->run();