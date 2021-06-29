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


class FilterTextLess
{
    static public function getName()
    {
        return 'text_less';
    }

    static public function getOptions()
    {
        return ['pre_escape' => 'html', 'is_safe' => ['html']];
    }

    /**
     * Cut of text on a pagebreak.
     *
     * @param        $value
     * @param string $replace
     * @param string $break
     *
     * @return string|null
     */
    static public function load($value, $replace = '...', $break = '<!-- pagebreak -->')
    {
        if (!isset($value)) {
            return null;
        }

        $pos = stripos($value, $break);
        return $pos === false ? $value : substr($value, 0, $pos) . $replace;
    }
}