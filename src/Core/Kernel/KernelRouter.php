<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/potara-php
 * @copyright Copyright (c) 2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
 * @license   https://github.com/potara/potara-php/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Kernel;


class KernelRouter
{
    /**
     * @param $modules
     * @param Kernel $kernel
     * @return $this
     */
    public function loadRoutes($modules, Kernel &$kernel)
    {
        $this->factoryRouter($modules['router'], $kernel);
        return $this;
    }


    /**
     * @param array $routers
     * @param Kernel $kernel
     */
    protected function factoryRouter($routers = [], Kernel &$kernel)
    {
        if (!empty($routers) and is_array($routers)) {
            foreach ($routers as $routerName => $routerClass) {
                /**
                 * Se $routerClass for um array, reinicie o processo, caso não, crie o crupo de rotas
                 * If $routerClass for an array, restart the process, if no, create the route group
                 */
                if (is_array($routerClass)) {
                    self::factoryRouter($routerClass, $kernel);
                } else {
                    $nameRouter = "/";
                    if ($routerName != '') {
                        $nameRouter .= $routerName;
                    }
                    $kernel->app->group($nameRouter, $routerClass);
                }
            }
        }
    }
}
