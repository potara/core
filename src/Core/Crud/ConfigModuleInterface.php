<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud;

interface ConfigModuleInterface
{
    /**
     * @return bool
     */
    public static function isEnable(): bool;

    /**
     * @return array
     */
    public static function getConf(): array;
}
