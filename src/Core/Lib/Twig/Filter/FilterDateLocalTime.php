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


class FilterDateLocalTime
{
    static public function getName()
    {
        return 'localtime';
    }

    /**
     * @param        $date
     * @param string $format
     * @param string $calendar
     *
     * @return string|null
     */
    static public function load($date, $format = 'short', $calendar = 'gregorian')
    {
        return (new BaseFilterData())->formatLocal($date, false, $format, $calendar);
    }


}