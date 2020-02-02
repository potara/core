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

class KernelRouter
{

    /**
     * @param App $app
     *
     * @return $this
     */
    public function load(App &$app)
    {
        $routers = $app->getContainer()
                       ->get('modules_load')['router'];

        $this->factoryRouter($routers, $app);

        return $this;
    }

    /**
     * @param array $routers
     * @param App   $app
     */
    protected function factoryRouter($routers = [], App &$app)
    {
        if (!empty($routers) and is_array($routers)) {
            array_walk($routers, function ($routerClass, $routerName) use (&$app)
            {
                /**
                 * Se $routerClass for um array, reinicie o processo, caso não, crie o crupo de rotas
                 * If $routerClass for an array, restart the process, if no, create the route group
                 */
                if (is_array($routerClass)) {
                    self::factoryRouter($routerClass, $app);
                }
                else {
                    $nameRouter = "/";
                    if ($routerName != '') {
                        $nameRouter .= $routerName;
                    }
                    $app->group($nameRouter, $routerClass);
                }
            });
        }
    }
}
