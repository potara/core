<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace App\Index\Router;


use App\Index\Controller\IndexController;
use Potara\Core\RouterInterface;
use Slim\Routing\RouteCollectorProxy;

class IndexRouter implements RouterInterface
{

    public function __invoke(RouteCollectorProxy $router)
    {
        $indexController = IndexController::class;
        $router->get('', [$indexController, 'index']);
    }
}
