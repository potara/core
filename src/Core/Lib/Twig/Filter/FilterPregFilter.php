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


class FilterPregFilter
{
    static public function getName()
    {
        return 'preg_filter';
    }

    /**
     * @param        $subject
     * @param        $pattern
     * @param string $replacement
     * @param int    $limit
     *
     * @return false|string
     */
    static public function load($subject, $pattern, $replacement = '', $limit = -1)
    {
        return !isset($subject) ? null : preg_filter($pattern, $replacement, $subject, $limit);
    }
}