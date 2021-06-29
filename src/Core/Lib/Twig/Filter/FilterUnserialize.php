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


class FilterUnserialize
{
    static public function getName()
    {
        return 'unserialize';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * @param null $value
     *
     * @return array|mixed
     */
    static public function load($value = null)
    {
        return !empty($value) && is_string($value) ? unserialize($value) : [];
    }
}