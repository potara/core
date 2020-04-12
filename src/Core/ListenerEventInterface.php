<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core;


use DI\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;

interface ListenerEventInterface
{
    public function load(Container &$container, EventDispatcher &$eventDispatcher, $args = []);
}