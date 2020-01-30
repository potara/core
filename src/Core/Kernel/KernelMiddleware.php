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


class KernelMiddleware
{
    /**
     * Registrando middlewares
     * Registering middlewares
     *
     * @param $modules
     * @param KernelInterface $kernel
     * @return $this
     */
    public function loadMiddlewares($modules, Kernel &$kernel)
    {
        $middlewares = $modules['middleware'];
        if (!empty($middlewares)) {
            /**
             * Registrando middlewares
             *
             * Registering middlewares
             */
            array_walk($middlewares, function ($args, $middleware) use ($kernel) {
                $this->addMiddleware($this->factoryMiddlewares($middleware, $args, $kernel), $kernel);
            });
        }

        return $this;
    }

    /**
     * Registrando middleware
     * Registering middleware
     *
     * @param $middleware
     * @param KernelInterface $kernel
     * @return $this
     */
    public function addMiddleware($middleware, Kernel &$kernel)
    {
        $kernel->app->add($middleware);
        return $this;
    }


    protected function factoryMiddlewares($middleware, $args, Kernel &$kernel)
    {
        /**
         * Se não existe argumentos, registre o middleware
         *
         * If there are no arguments, register the middleware
         */
        if (empty($args)) {
            return $middleware;
        } else {
            if (is_array($args)) {
                return new $middleware($kernel->getContainer(), $args);
            } elseif (class_exists($args)) {
                /**
                 * É um objeto e o arquivo existe, entçao carregue o arquivo e chame o __invoke
                 *
                 * It is an object and the fike exists, then load the file and call __invoke
                 */
                return new $middleware((new $args)($kernel->app));
            }
        }
    }

}
