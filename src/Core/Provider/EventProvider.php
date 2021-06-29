<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Provider;


use Slim\App;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventProvider implements ProviderInerface
{

    public function load(App &$app, $args = [])
    {

        $app->getContainer()
            ->set('event_dispatcher', function ()
            {
                return new EventDispatcher();
            });
    }
}