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


class FilterPregMatch
{
    static public function getName()
    {
        return 'preg_match';
    }

    /**
     * @param $subject
     * @param $pattern
     *
     * @return false|int|null
     */
    static public function load($subject, $pattern)
    {
        return !isset($subject) ? null : preg_match($pattern, $subject);
    }
}