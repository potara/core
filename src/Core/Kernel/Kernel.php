<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Kernel;

use \DI\Bridge\Slim\Bridge as SlimBridge;
use Potara\Core\Handlers\HttpErrorHandler;
use Potara\Core\Handlers\ShutdownHandler;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

class Kernel
{
    public $app;

    public function __construct($conf = [])
    {
        $kernelConf = new KernelConf($conf);
        $this->app  = SlimBridge::create();

        // CUSTOM HANDLERS
        $displayErrorDetails = true;

        $callableResolver = $this->app->getCallableResolver();
        $responseFactory  = $this->app->getResponseFactory();

        $serverRequestCreator = ServerRequestCreatorFactory::create();
        $request              = $serverRequestCreator->createServerRequestFromGlobals();

        $errorHandler    = new HttpErrorHandler($callableResolver, $responseFactory);
        $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
        register_shutdown_function($shutdownHandler);

        ///
        // Add Routing Middleware
        $this->app->addRoutingMiddleware();

        // Add Error Handling Middleware
        $errorMiddleware = $this->app->addErrorMiddleware($displayErrorDetails, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);
        ////////////////////////////

        //TWIG
        $this->app->getContainer()->set('view', function () {
            $basePath = $_SERVER['DOCUMENT_ROOT'] . '/../app';
            $cache    = $_SERVER['DOCUMENT_ROOT'] . '/../storage/cache/twig';
            return new Twig($basePath, ['cache' => $cache]);
        });
        $this->app->add(TwigMiddleware::createFromContainer($this->app));


    }
}
