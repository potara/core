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


class FilterTextParagraph
{
    static public function getName()
    {
        return 'text_paragraph';
    }

    static public function getOptions()
    {
        return ['pre_escape' => 'html', 'is_safe' => ['html']];
    }

    /**
     * Add paragraph and line breaks to text.
     *
     * @param $value
     *
     * @return string|null
     */
    static public function load($value)
    {
        if (!isset($value)) {
            return null;
        }

        return '<p>' . preg_replace(['~\n(\s*)\n\s*~', '~(?<!</p>)\n\s*~'], ["</p>\n\$1<p>", "<br>\n"], trim($value)) . '</p>';
    }
}