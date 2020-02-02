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


use Slim\App;

class KernelMiddleware
{
    /**
     * @param App $app
     *
     * @return $this
     */
    public function load(App &$app)
    {
        $middlewares = $app->getContainer()
                           ->get('modules_load')['middleware'];

        array_walk($middlewares, function ($args, $middleware) use (&$app)
        {
            $prepareArgs = !is_array($args) && class_exists($args) ? new $args() : $args;
            $app->add(new $middleware($app, $prepareArgs));
        });

        return $this;
    }

}
