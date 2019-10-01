<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace App\Index\Router;


use App\Index\Controller\IndexController;
use Slim\Routing\RouteCollectorProxy;

class IndexRouter
{

    public function __invoke(RouteCollectorProxy $router)
    {
        $indexController = IndexController::class;
        $router->get('', [$indexController, 'index']);
    }
}