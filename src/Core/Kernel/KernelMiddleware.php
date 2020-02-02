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

        if (!empty($middlewares)) {
            foreach ($middlewares as $middleware => $args) {
                $app->add($this->factoryMiddlewares($middleware, $args, $app));
            }
        }

        return $this;
    }


    /**
     * @param     $middleware
     * @param     $args
     * @param App $app
     *
     * @return mixed
     */
    protected function factoryMiddlewares($middleware, $args, App &$app)
    {

        /**
         * Se não existe argumentos, registre o middleware
         *
         * If there are no arguments, register the middleware
         */
        if (empty($args)) {
            return $middleware;
        }
        else {
            if (is_array($args)) {
                return new $middleware($app, $args);
            }
            elseif (class_exists($args)) {
                /**
                 * É um objeto e o arquivo existe, entçao carregue o arquivo e chame o __invoke
                 *
                 * It is an object and the fike exists, then load the file and call __invoke
                 */
                return new $middleware((new $args)($app));
            }
        }
    }

}
