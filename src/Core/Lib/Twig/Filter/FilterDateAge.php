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


class FilterDateAge
{
    static public function getName()
    {
        return 'dateage';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($value)
    {
        if (!isset($value)) {
            return null;
        }

        $date = (new BaseFilterData())->valueToDateTime($value);

        return $date->diff(new \DateTime())->format('%y');
    }

}