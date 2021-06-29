<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Lib;


use Cocur\Slugify\Slugify;

final class FacotrySlug
{
    static public function factory($string)
    {
        if (!is_string($string)) {
            return null;
        }
        return ((new Slugify())->activateRuleset('esperanto'))->slugify($string);
    }
}
