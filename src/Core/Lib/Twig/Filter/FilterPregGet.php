<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Lib\Twig\Filter;


class FilterPregGet
{
    static public function getName()
    {
        return 'preg_get';
    }

    /**
     * @param     $value
     * @param     $pattern
     * @param int $group
     *
     * @return mixed|null
     */
    static public function load($value, $pattern, $group = 0)
    {
        if (!isset($value)) {
            return null;
        }

        return preg_match($pattern, $value, $matches) && isset($matches[$group]) ? $matches[$group] : null;
    }
}