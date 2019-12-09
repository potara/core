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

class KernelProvider
{
    /**
     * @param $modules
     * @param KernelInterface $kernel
     * @return $this
     */
    public function loadProvider($modules, Kernel &$kernel)
    {
        $providers = $modules['provider'];
        if (!empty($providers)) {
            foreach ($providers as $provider => $args) {
                $this->registerProvider(new $provider, $args, $kernel);
            }
        }

        return $this;
    }

    /**
     * @param ServiceProviderInterface $provider
     * @param array $values
     * @param KernelInterface $kernel
     * @return $this
     */
    public function registerProvider(ServiceProviderInterface $provider, $values = [], KernelInterface $kernel)
    {
        $kernel->getContainer()->register($provider, $values);
        return $this;
    }
}
