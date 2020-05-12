<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Jwt;


use Potara\Core\RouterInterface;
use Slim\Routing\RouteCollectorProxy;

class JwtRouter implements RouterInterface
{

    public function __invoke(RouteCollectorProxy $router)
    {
        $indexController = JwtController::class;

        $router->post('', [$indexController, 'authPublic'])
            ->setName('auth-public');

        $router->post('/login', [$indexController, 'authLogin'])
            ->setName('auth-login');

        $router->post('/refresh', [$indexController, 'authRefresh'])
            ->setName('auth-refresh');
    }
}
