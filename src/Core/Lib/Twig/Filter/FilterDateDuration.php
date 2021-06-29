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


class FilterDateDuration
{
    static public function getName()
    {
        return 'dateduration';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * @param          $value
     * @param string[] $units
     * @param string   $separator
     *
     * @return string|null
     */
    static public function load($value, $units = ['s', 'm', 'h', 'd', 'w', 'y'], $separator = ' ')
    {
        if (!isset($value)) {
            return null;
        }

        $parts = (new BaseFilterData())->splitDuration($value, count($units) - 1) + array_fill(0, 6, null);

        $duration = '';

        for ($i = 5; $i >= 0; $i--) {
            if (isset($parts[$i]) && isset($units[$i])) {
                $duration .= $separator . $parts[$i] . $units[$i];
            }
        }

        return trim($duration, $separator);
    }


}