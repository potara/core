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


class FilterJsonEncode
{
    static public function getName()
    {
        return 'json_encode';
    }

    static public function getOptions()
    {
        return [];
    }
    
    /**
     * @param array $value
     *
     * @return false|string
     */
    static public function load($value = [])
    {
        return json_encode($value);
    }
}