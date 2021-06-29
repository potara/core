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


class FilterAsArray
{
    static public function getName()
    {
        return 'as_array';
    }

    static public function getOptions()
    {
        return [];
    }
    
    /**
     * @param $value
     *
     * @return array
     */
    static public function load($value)
    {
        return is_object($value) ? get_object_vars($value) : (array)$value;
    }
}