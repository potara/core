<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider\Swiftmailer\Listener;

use DI\Container;
use Potara\Core\Kernel\KernelConf;
use Potara\Core\Provider\Swiftmailer\Events\SwiftmailerSendMailEvent;
use Symfony\Component\EventDispatcher\Event;
use Potara\Core\Provider\Swiftmailer\SwiftmailerEntity;

class SwiftmailerSendMailListener
{
    public $container;

    public function __construct(Container &$container)
    {
        $this->container = $container;
    }

    /**
     * @param SwiftmailerSendMailEvent $event
     *
     * @return int
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function onSendMail(SwiftmailerSendMailEvent $event) : int
    {

        /** @var KernelConf $kernelConf */
        $kernelConf  = $this->container->get('kernel-conf');
        /** @var SwiftmailerEntity $swiftmailer */
        $swiftmailer = $kernelConf->getConf('swiftmailer');
        $swiftmailer->message = $event->getMessage();
        return $swiftmailer->send();
    }
}