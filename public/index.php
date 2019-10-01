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
require_once __DIR__.'./../vendor/autoload.php';

use App\Index\Router\IndexRouter;
use Potara\Core\Handlers\HttpErrorHandler;
use Potara\Core\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;

$app = \DI\Bridge\Slim\Bridge::create();

// Set that to your needs
$displayErrorDetails = true;

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$app->group('/',IndexRouter::class);

$app->run();