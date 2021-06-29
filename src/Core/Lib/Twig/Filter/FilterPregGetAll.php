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


class FilterPregGetAll
{
    static public function getName()
    {
        return 'preg_get_all';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * @param     $value
     * @param     $pattern
     * @param int $group
     *
     * @return array|mixed|null
     */
    static public function load($value, $pattern, $group = 0)
    {
        if (!isset($value)) {
            return null;
        }

        return preg_match_all($pattern, $value, $matches, PREG_PATTERN_ORDER) && isset($matches[$group]) ? $matches[$group] : [];
    }
}