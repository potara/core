<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer;


use DI\Container;
use Potara\Core\ListenerEventInterface;
use Potara\Core\Provider\Swiftmailer\Events\SwiftmailerSendMailEvent;
use Potara\Core\Provider\Swiftmailer\Listener\SwiftmailerSendMailListener;
use Symfony\Component\EventDispatcher\EventDispatcher;

class SwiftmailerListenerEvents implements ListenerEventInterface
{
    /**
     * @param Container       $container
     * @param EventDispatcher $eventDispatcher
     * @param array           $args
     *
     * @return $this
     */
    public function load(Container &$container, EventDispatcher &$eventDispatcher, $args = [])
    {
        $SwiftmailerSendMailListener = new SwiftmailerSendMailListener($container);
        $eventDispatcher->addListener(SwiftmailerSendMailEvent::NAME, [$SwiftmailerSendMailListener, SwiftmailerSendMailEvent::METHOD]);
    }
}