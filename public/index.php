<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once __DIR__ . './../vendor/autoload.php';

use App\Index\Router\IndexRouter;
use DI\Container;
use Potara\Core\Handlers\HttpErrorHandler;
use Potara\Core\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigMiddleware;

$app = \DI\Bridge\Slim\Bridge::create();

// CUSTOM HANDLERS
$displayErrorDetails = true;

$callableResolver = $app->getCallableResolver();
$responseFactory  = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request              = $serverRequestCreator->createServerRequestFromGlobals();

$errorHandler    = new HttpErrorHandler($callableResolver, $responseFactory);
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);
///
// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);
////////////////////////////

//TWIG
$app->getContainer()->set('view', function () {
    $basePath = $_SERVER['DOCUMENT_ROOT'] . '/../app';
    $cache    = $_SERVER['DOCUMENT_ROOT'] . '/../storage/cache/twig';
    return new Twig($basePath, ['cache' => $cache]);
});
$app->add(TwigMiddleware::createFromContainer($app));
////////////////////////////

$app->group('/', IndexRouter::class);

$app->get('/twig', function ($request, $response, Container $container) {

    return $container->get('view')->render($response, 'Index/View/index.html.twig', [
        'local' => 'teste twig'
    ]);
});

$app->run();