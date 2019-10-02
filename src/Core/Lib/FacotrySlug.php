<?php


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