<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Provider\Doctrine;


use Potara\Core\Kernel\KernelConf;
use Potara\Core\Provider\ProviderInerface;
use Slim\App;

class DoctrineProvider implements ProviderInerface
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

        $doctrineConf = $kernelConf->getConf()['doctrine'];
        $listConnName = array_keys($doctrineConf);

        array_walk($listConnName, function ($coonName) use (&$app, &$doctrineConf) {
            $app->getContainer()->set("db:$coonName", new DoctrineEntity($doctrineConf[$coonName]));
        });

        return $this;
    }
}