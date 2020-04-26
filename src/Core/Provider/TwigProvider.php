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
use Potara\Core\Lib\Twig\TwigExtraExtentions;
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
            ->set('view', function () use (&$kernelConf) {

                $twig = Twig::create($kernelConf->modules_path, [
                    [
                        'degub' => $kernelConf->debug,
                        'cache' => $kernelConf->cache_twig
                    ]
                ]);
                $twig->addExtension(new TwigExtraExtentions());

                return $twig;
            });

        $app->add(TwigMiddleware::createFromContainer($app));
        return $this;
    }
}