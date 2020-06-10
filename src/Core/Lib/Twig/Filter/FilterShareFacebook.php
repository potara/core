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


class FilterShareFacebook
{
    static public function getName()
    {
        return 'shade_facebook';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($url, $display = null, $redirect = null)
    {
        if (empty($url)) {
            return "";
        }

        $link = "https://www.facebook.com/sharer/sharer.php";
        $params = array_filter([
            'u'            => $url,
            'display'      => empty($display) ? false : $display,
            'redirect_uri' => empty($redirect) ? false : $redirect,
        ]);

        return $link . '?' . http_build_query($params);

    }

}