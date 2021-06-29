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


class FilterShareWhatsapp
{
    static public function getName()
    {
        return 'shade_whatsapp';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($text, $phone = null)
    {
        if (empty($url)) {
            return "";
        }

        $link = "https://twitter.com/home";
        $params = array_filter([
            'phone' => empty($phone) ? false : $phone,
            'text'  => empty($text) ? false : $text
        ]);

        return $link . '?' . http_build_query($params);
    }

}