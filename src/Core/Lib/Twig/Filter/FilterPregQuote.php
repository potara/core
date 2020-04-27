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


class FilterPregQuote
{
    static public function getName()
    {
        return 'preg_grep';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * @param $subject
     * @param $delimiter
     *
     * @return string|null
     */
    static public function load($subject, $delimiter)
    {
        return !isset($subject) ? null : preg_quote($subject, $delimiter);
    }
}