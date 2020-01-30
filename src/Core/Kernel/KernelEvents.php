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


class KernelEvents
{
    /**
     * @param $modules
     * @param KernelInterface $kernel
     * @return $this
     * @throws ContainerException
     */
    public function loadEvents($modules, Kernel &$kernel)
    {
        $events = $modules['event'];
        if (!empty($events)) {
            $container = $kernel->getContainer();

            /**
             * O provider de eventos está registrado?
             * Is the event provider registred?
             */
            if (!empty($container->get('p_events'))) {
                foreach ($events as $event => $args) {
                    $event::load($container, $container->get('p_events'), $args);
                }
            }
        }
        return $this;
    }
}
