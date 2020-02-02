<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace App\Index;


use Potara\Core\Crud\ConfigModuleInterface;

class ConfigModule implements ConfigModuleInterface
{
    public static function isEnable() : bool
    {
        return true;
    }

    public static function getConf() : array
    {
        return [
            'router'   => [
                '' => \App\Index\Router\IndexRouter::class
            ],
            'provider' => [//                \App\Index\Provider\IndexProvider::class => []
            ],
            'event'    => [//                \App\Index\Event\IndexEvent::class => []
            ]
        ];
    }
}
