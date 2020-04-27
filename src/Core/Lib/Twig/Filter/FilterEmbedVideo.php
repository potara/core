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


class FilterEmbedVideo
{
    static public function getName()
    {
        return 'embed_video';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($code, $origin)
    {
        switch ($origin) {
            case "youtube":
                return "https://www.youtube.com/embed/{$code}";
                break;
            case "vimeo":
                return "https://player.vimeo.com/video/{$code}";
                break;
            default:
                return $code;
                break;
        }
    }
}