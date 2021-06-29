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


class FilterTextLine
{
    static public function getName()
    {
        return 'text_line';
    }

    static public function getOptions()
    {
        return [];
    }

    /**
     * Get a single line
     *
     * @param     $value
     * @param int $line
     *
     * @return mixed|string|null
     */
    static public function load($value, $line = 1)
    {
        if (!isset($value)) {
            return null;
        }

        $lines = explode("\n", $value);

        return isset($lines[$line - 1]) ? $lines[$line - 1] : null;
    }
}