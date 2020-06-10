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


class FilterShareLinkedin
{
    static public function getName()
    {
        return 'shade_linkedin';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($url, $title = null, $summary = null)
    {
        if (empty($url)) {
            return "";
        }

        $link = "http://www.linkedin.com/shareArticle";
        $params = array_filter([
            'mini'    => 'true',
            'url'     => $url,
            'title'   => empty($title) ? false : $title,
            'summary' => empty($summary) ? false : $summary,
        ]);

        return $link . '?' . http_build_query($params);
    }

}