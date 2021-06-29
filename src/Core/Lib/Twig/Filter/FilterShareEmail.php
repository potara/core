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


class FilterShareEmail
{
    static public function getName()
    {
        return 'shade_email';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($email, $subject = null, $body = null, $cc = null, $bcc = null)
    {
        if (empty($email)) {
            return "";
        }

        $link   = "mailto:{$email}";
        $params = array_filter([
            'cc'      => empty($cc) ? false : $cc,
            'bcc'     => empty($bcc) ? false : $bcc,
            'subject' => empty($subject) ? false : $subject,
            'body'    => empty($body) ? false : $body,
        ]);

        return empty($params) ? $link : $link . '?' . http_build_query($params);
    }

}