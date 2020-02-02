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

class KernelProvider
{

    /**
     * @param App $app
     *
     * @return $this
     */
    public function load(App &$app)
    {
        $providers = $app->getContainer()
                         ->get('modules_load')['provider'];


        array_walk($providers, function ($args, $provider) use (&$app)
        {
            (new $provider())->load($app, $args);
        });

        return $this;
    }
}
