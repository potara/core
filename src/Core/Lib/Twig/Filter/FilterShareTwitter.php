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


class FilterShareTwitter
{
    static public function getName()
    {
        return 'shade_twitter';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($url, $text = null)
    {
        if (empty($url)) {
            return "";
        }

        $link = "https://twitter.com/home";
        $params = array_filter([
            'status' => $url,
            'text'   => empty($text) ? false : $text
        ]);

        return $link . '?' . http_build_query($params);
    }

}