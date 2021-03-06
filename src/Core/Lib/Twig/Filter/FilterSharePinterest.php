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


class FilterSharePinterest
{
    static public function getName()
    {
        return 'shade_linkedin';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($url, $image = null, $description = null)
    {
        if (empty($url)) {
            return "";
        }

        $link = "http://pinterest.com/pin/create/button/";
        $params = array_filter([
            'url'         => $url,
            'media'       => empty($image) ? false : $image,
            'description' => empty($description) ? false : $description,
        ]);

        return $link . '?' . http_build_query($params);
    }

}