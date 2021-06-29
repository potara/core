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


class FilterTextTruncate
{
    static public function getName()
    {
        return 'text_truncate';
    }

    static public function getOptions()
    {
        return ['pre_escape' => 'html', 'is_safe' => ['html']];
    }

    /**
     * Cut of text if it's to long.
     *
     * @param        $value
     * @param        $length
     * @param string $replace
     *
     * @return string|null
     */
    static public function load($value, $length, $replace = '...')
    {
        if (!isset($value)) {
            return null;
        }

        return strlen($value) <= $length ? $value : substr($value, 0, $length - strlen($replace)) . $replace;
    }
}