<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Lib\Twig\Filter;


class FilterArraySum
{
    static public function getName()
    {
        return 'array_sum';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * @param $value
     *
     * @return float|int|null
     */
    static public function load($value)
    {
        return isset($value) ? array_sum((array) $value) : null;;
    }
}