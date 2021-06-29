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


class FilterDateLocalDate
{
    static public function getName()
    {
        return 'localdate';
    }

    static public function getOptions()
    {
        return [];
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
        return (new BaseFilterData())->formatLocal($date, $format, false, $calendar);
    }


}