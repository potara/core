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


class FilterJsonDecode
{
    static public function getName()
    {
        return 'json_decode';
    }

    /**
     * @param string $value
     * @param bool   $assoc
     *
     * @return mixed
     */
    static public function load(string $value, $assoc = true)
    {
        return json_decode($value, $assoc);
    }
}