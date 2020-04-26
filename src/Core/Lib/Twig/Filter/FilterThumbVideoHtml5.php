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


class FilterThumbVideoHtml5
{
    static public function getName()
    {
        return 'thumb_video_html5';
    }

    static public function load($code, $origin, $class = null, $alt = null)
    {
        $imageList = FilterThumbVideo::load($code, $origin);
        if (empty($imageList)) {
            return null;
        }

        return <<<HTML
<picture class="{$class}" alt="{$alt}">
<source srcset="{$imageList['max']}" media="(min-width: 1800px)">
<source srcset="{$imageList['sd']}" media="(min-width: 1366px)">
<source srcset="{$imageList['hd']}" media="(min-width: 480px)">
<source srcset="{$imageList['mq']}" media="(min-width: 320px)">
<source srcset="{$imageList['d']}" media="(min-width: 1px)">
<img src="{$imageList['sd']}" alt="{$alt}">
</picture>
HTML;

    }
}