<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider;


use Potara\Core\Kernel\KernelConf;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

class TwigProvider implements ProviderInerface
{

    public function load(App &$app, $args = [])
    {
        /** @var KernelConf $kernelConf */
        $kernelConf = $app->getContainer()
                          ->get('kernel-conf');

        $app->getContainer()
            ->set('view', function () use (&$kernelConf)
            {
                return Twig::create($kernelConf->modules_path, ['cache' => $kernelConf->cache . '/twig']);
            });

        $app->add(TwigMiddleware::createFromContainer($app));
        return $this;
    }
}