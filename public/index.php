<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
require_once __DIR__ . './../vendor/autoload.php';

use App\Index\Router\IndexRouter;
use DI\Container;
use Potara\Core\Kernel\Kernel;

$app = (new Kernel())->app;

///////////////////////////

$app->group('/', IndexRouter::class);

$app->get('/twig', function ($request, $response, Container $container) {

    return $container->get('view')->render($response, 'Index/View/index.html.twig', [
        'local' => 'teste twig'
    ]);
});

$app->run();
