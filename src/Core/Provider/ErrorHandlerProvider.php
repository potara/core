<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider;


use Potara\Core\Handlers\HttpErrorHandler;
use Potara\Core\Handlers\ShutdownHandler;
use Slim\App;
use Slim\Factory\ServerRequestCreatorFactory;

class ErrorHandlerProvider implements ProviderInerface
{

    public function load(App &$app, $args = [])
    {
        if (!$app->getContainer()->get('kernel-conf')->debug) {
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
        }
    }
}