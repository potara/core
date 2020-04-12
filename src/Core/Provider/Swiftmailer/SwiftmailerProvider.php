<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer;


use Potara\Core\Kernel\KernelConf;
use Potara\Core\Provider\ProviderInerface;
use Slim\App;

class SwiftmailerProvider implements ProviderInerface
{
    /**
     * @param App   $app
     * @param array $args
     *
     * @return mixed
     */
    public function load(App &$app, $args = [])
    {
        /** @var KernelConf $kernelConf */
        $kernelConf = $app->getContainer()
                          ->get('kernel-conf');

        $app->getContainer()
            ->set('swiftmailer', $kernelConf->getConf()['swiftmailer']);
        return $this;
    }

}