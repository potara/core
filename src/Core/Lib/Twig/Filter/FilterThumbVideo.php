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


class FilterThumbVideo
{
    static public function getName()
    {
        return 'thumb_video';
    }

    static public function getOptions()
    {
        return [];
    }

    static public function load($code, $origin)
    {
        switch ($origin) {
            case "youtube":
                return [
                    'd'   => "http://i.ytimg.com/vi/{$code}/default.jpg",
                    'mq'  => "http://i.ytimg.com/vi/{$code}/mqdefault.jpg",
                    'hq'  => "http://i.ytimg.com/vi/{$code}/hqdefault.jpg",
                    'sd'  => "http://i.ytimg.com/vi/{$code}/sddefault.jpg",
                    'max' => "http://i.ytimg.com/vi/{$code}/maxresdefault.jpg"
                ];
                break;
            case "vimeo":
                try {
                    $vimeo = current(json_decode(file_get_contents("http://vimeo.com/api/v2/video/{$code}.json"), true));
                    return [
                        'd'   => $vimeo['thumbnail_small'],
                        'mq'  => $vimeo['thumbnail_medium'],
                        'hq'  => $vimeo['thumbnail_medium'],
                        'sd'  => $vimeo['thumbnail_large'],
                        'max' => $vimeo['thumbnail_large']
                    ];
                } catch (\Exception $e) {
                    return [];
                }

                break;
            default:
                return $code;
                break;
        }
    }
}