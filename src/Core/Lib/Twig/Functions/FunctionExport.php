<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Lib\Twig\Functions;


class FunctionExport
{
    static public function getName()
    {
        return 'export';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($value)
    {
        echo '<pre>';
        var_export($value);
        echo '</pre>';
    }
}