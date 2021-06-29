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


class FilterTextLinkify
{
    static public function getName()
    {
        return 'text_linkify';
    }

    static public function getOptions()
    {
        return ['pre_escape' => 'html', 'is_safe' => ['html']];
    }

    /**
     * Turn all URLs in clickable links.
     *
     * @param          $value
     * @param string[] $protocols
     * @param array    $attributes
     * @param string   $mode
     *
     * @return string|string[]|null
     */
    static public function load($value, $protocols = ['http', 'mail'], array $attributes = [], $mode = 'normal')
    {
        if (!isset($value)) {
            return null;
        }

        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
        }

        $links = [];

        // Extract existing links and tags
        $text = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
            return '<' . array_push($links, $match[1]) . '>';
        }, $value);

        // Extract text links for each protocol
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':
                    $text = (new FilterTextLinkify)->linkifyHttp($protocol, $text, $links, $attr, $mode);
                    break;
                case 'mail':
                    $text = (new FilterTextLinkify)->linkifyMail($text, $links, $attr);
                    break;
                default:
                    $text = (new FilterTextLinkify)->linkifyOther($protocol, $text, $links, $attr, $mode);
                    break;
            }
        }

        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
            return $links[$match[1] - 1];
        }, $text);
    }


    /**
     * Linkify a HTTP(S) link.
     *
     * @param string $protocol  'http' or 'https'
     * @param string $text
     * @param array  $links     OUTPUT
     * @param string $attr
     * @param string $mode
     * @return string
     */
    protected function linkifyHttp($protocol, $text, array &$links, $attr, $mode)
    {
        $regexp = $mode != 'all'
            ? '~(?:(https?)://([^\s<>]+)|(?<!\w@)\b(www\.[^\s<>]+?\.[^\s<>]+))(?<![\.,:;\?!\'"\|])~i'
            : '~(?:(https?)://([^\s<>]+)|(?<!\w@)\b([^\s<>@]+?\.[^\s<>]+)(?<![\.,:]))~i';

        return preg_replace_callback($regexp, function ($match) use ($protocol, &$links, $attr) {
            if ($match[1]) {
                $protocol = $match[1];
            }
            $link = $match[2] ?: $match[3];

            return '<' . array_push($links, '<a' . $attr . ' href="' . $protocol . '://' . $link . '">'
                    . rtrim($link, '/') . '</a>') . '>';
        }, $text);
    }

    /**
     * Linkify a mail link.
     *
     * @param string $text
     * @param array  $links     OUTPUT
     * @param string $attr
     * @return string
     */
    protected function linkifyMail($text, array &$links, $attr)
    {
        $regexp = '~([^\s<>]+?@[^\s<>]+?\.[^\s<>]+)(?<![\.,:;\?!\'"\|])~';

        return preg_replace_callback($regexp, function ($match) use (&$links, $attr) {
            return '<' . array_push($links, '<a' . $attr . ' href="mailto:' . $match[1] . '">' . $match[1] . '</a>')
                . '>';
        }, $text);
    }


    /**
     * Linkify a link.
     *
     * @param string $protocol
     * @param string $text
     * @param array  $links     OUTPUT
     * @param string $attr
     * @param string $mode
     * @return string
     */
    protected function linkifyOther($protocol, $text, array &$links, $attr, $mode)
    {
        if (strpos($protocol, ':') === false) {
            $protocol .= in_array($protocol, ['ftp', 'tftp', 'ssh', 'scp']) ? '://' : ':';
        }

        $regexp = $mode != 'all'
            ? '~' . preg_quote($protocol, '~') . '([^\s<>]+)(?<![\.,:;\?!\'"\|])~i'
            : '~([^\s<>]+)(?<![\.,:])~i';

        return preg_replace_callback($regexp, function ($match) use ($protocol, &$links, $attr) {
            return '<' . array_push($links, '<a' . $attr . ' href="' . $protocol . $match[1] . '">' . $match[1]
                    . '</a>') . '>';
        }, $text);
    }

}