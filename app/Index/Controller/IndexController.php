<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace App\Index\Controller;


use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController
{
    public function index(Request $request, Response $response,Container $container)
    {
        return $container->get('view')->render($response, 'Index/View/index.html.twig', [
            'local' => 'IndexController:index'
        ]);
    }
}