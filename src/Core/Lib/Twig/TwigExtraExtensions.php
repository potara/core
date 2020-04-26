<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Lib\Twig;


use Potara\Core\Lib\Twig\Filter\FilterArrayHtmlAttr;
use Potara\Core\Lib\Twig\Filter\FilterArrayKeys;
use Potara\Core\Lib\Twig\Filter\FilterArrayProduct;
use Potara\Core\Lib\Twig\Filter\FilterArraySum;
use Potara\Core\Lib\Twig\Filter\FilterArrayValues;
use Potara\Core\Lib\Twig\Filter\FilterAsArray;
use Potara\Core\Lib\Twig\Filter\FilterDateAge;
use Potara\Core\Lib\Twig\Filter\FilterDateDuration;
use Potara\Core\Lib\Twig\Filter\FilterDateLocalDate;
use Potara\Core\Lib\Twig\Filter\FilterDateLocalDateTime;
use Potara\Core\Lib\Twig\Filter\FilterDateLocalTime;
use Potara\Core\Lib\Twig\Filter\FilterEmbedVideo;
use Potara\Core\Lib\Twig\Filter\FilterJsonDecode;
use Potara\Core\Lib\Twig\Filter\FilterJsonEncode;
use Potara\Core\Lib\Twig\Filter\FilterPregFilter;
use Potara\Core\Lib\Twig\Filter\FilterPregGet;
use Potara\Core\Lib\Twig\Filter\FilterPregGetAll;
use Potara\Core\Lib\Twig\Filter\FilterPregGrep;
use Potara\Core\Lib\Twig\Filter\FilterPregMatch;
use Potara\Core\Lib\Twig\Filter\FilterPregQuote;
use Potara\Core\Lib\Twig\Filter\FilterPregReplace;
use Potara\Core\Lib\Twig\Filter\FilterPregSplit;
use Potara\Core\Lib\Twig\Filter\FilterSerialize;
use Potara\Core\Lib\Twig\Filter\FilterThumbVideo;
use Potara\Core\Lib\Twig\Filter\FilterThumbVideoHtml5;
use Potara\Core\Lib\Twig\Filter\FilterUnserialize;
use Potara\Core\Lib\Twig\Functions\FunctionDump;
use Potara\Core\Lib\Twig\Functions\FunctionExport;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigExtraExtensions extends AbstractExtension
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return 'potara';
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        $listFilter = [
            FilterJsonEncode::class, FilterJsonDecode::class, FilterSerialize::class, FilterUnserialize::class,
            FilterThumbVideo::class, FilterThumbVideoHtml5::class, FilterEmbedVideo::class,

            //Regular expression filters
            FilterPregFilter::class, FilterPregGrep::class, FilterPregMatch::class, FilterPregQuote::class,
            FilterPregReplace::class, FilterPregSplit::class, FilterPregGet::class, FilterPregGetAll::class,

            //Array Filters
            FilterArrayKeys::class, FilterArrayValues::class, FilterArrayHtmlAttr::class, FilterArrayProduct::class,
            FilterArraySum::class, FilterAsArray::class,

            //Date filters
            FilterDateLocalDate::class, FilterDateLocalTime::class, FilterDateLocalDateTime::class, FilterDateDuration::class,
            FilterDateAge::class
        ];

        return array_reduce($listFilter, function ($result, $filter) {
            $result[] = new TwigFilter($filter::getName(), [$filter, 'load']);
            return $result;
        }, []);
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        $listFunctions = [
            FunctionDump::class, FunctionExport::class
        ];

        return array_reduce($listFunctions, function ($result, $function) {
            $result[] = new TwigFunction($function::getName(), [$function, 'load']);
            return $result;
        }, []);
    }


}