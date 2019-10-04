<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
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