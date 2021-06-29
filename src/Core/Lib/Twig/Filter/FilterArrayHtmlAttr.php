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


class FilterArrayHtmlAttr
{
    static public function getName()
    {
        return 'html_attr';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($value, $numericPrefix = null, $argSeparator = null, $encType = PHP_QUERY_RFC1738)
    {
        return !isset($value) ? null : http_build_query($value, $numericPrefix, $argSeparator, $encType);
    }
}