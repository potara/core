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


class FunctionDump
{
    static public function getName()
    {
        return 'dump';
    }

    static public function load($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
}