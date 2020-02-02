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

use DI\Bridge\Slim\Bridge as SlimBridge;

class Kernel
{
    /** @var \Slim\App */
    public $app;

    public function __construct($conf = [])
    {
        $this->app  = SlimBridge::create();
        $kernelConf = new KernelConf($conf);
        $this->app->getContainer()
                  ->set('kernel-conf', $kernelConf);

        (new KernelModules())->load($this->app);
        (new KernelProvider())->load($this->app);
        (new KernelEvents())->load($this->app);
        (new KernelMiddleware())->load($this->app);
        (new KernelRouter())->load($this->app);

    }
}
