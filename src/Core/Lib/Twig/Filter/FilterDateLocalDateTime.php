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


class FilterDateLocalDateTime
{
    static public function getName()
    {
        return 'localdatetime';
    }

    /**
     * @param        $date
     * @param null   $format
     * @param string $calendar
     *
     * @return string|null
     */
    static public function load($date, $format = null, $calendar = 'gregorian')
    {
        if (is_array($format) || $format instanceof \stdClass || !isset($format)) {
            $formatDate = isset($format['date']) ? $format['date'] : null;
            $formatTime = isset($format['time']) ? $format['time'] : 'short';
        } else {
            $formatDate = $format;
            $formatTime = false;
        }

        return (new BaseFilterData())->formatLocal($date, $formatDate, $formatTime, $calendar);
    }


}