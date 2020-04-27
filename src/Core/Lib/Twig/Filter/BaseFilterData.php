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


use Twig\Error\RuntimeError;

final class BaseFilterData
{
    /**
     * Split duration into seconds, minutes, hours, days, weeks and years.
     *
     * @param int $seconds
     * @return array
     */
    public function splitDuration($seconds, $max)
    {
        if ($max < 1 || $seconds < 60) {
            return [$seconds];
        }

        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        if ($max < 2 || $minutes < 60) {
            return [$seconds, $minutes];
        }

        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        if ($max < 3 || $hours < 24) {
            return [$seconds, $minutes, $hours];
        }

        $days = floor($hours / 24);
        $hours = $hours % 24;
        if ($max < 4 || $days < 7) {
            return [$seconds, $minutes, $hours, $days];
        }

        $weeks = floor($days / 7);
        $days = $days % 7;
        if ($max < 5 || $weeks < 52) {
            return [$seconds, $minutes, $hours, $days, $weeks];
        }

        $years = floor($weeks / 52);
        $weeks = $weeks % 52;
        return [$seconds, $minutes, $hours, $days, $weeks, $years];
    }

    /**
     * Turn a value into a DateTime object
     *
     * @param string|int|\DateTime $date
     *
     * @return \DateTime
     */
    public function valueToDateTime($date)
    {
        if (!$date instanceof \DateTime) {
            $date = is_int($date) ? \DateTime::createFromFormat('U', $date) : new \DateTime((string) $date);
        }

        if ($date === false) {
            throw new RuntimeError("Invalid date '$date'");
        }

        return $date;
    }

    /**
     * Get configured intl date formatter.
     *
     * @param string|null $dateFormat
     * @param string|null $timeFormat
     * @param string      $calendar
     *
     * @return \IntlDateFormatter
     */
    public function getDateFormatter($dateFormat, $timeFormat, $calendar)
    {
        $datetype = isset($dateFormat) ? $this->getFormat($dateFormat) : null;
        $timetype = isset($timeFormat) ? $this->getFormat($timeFormat) : null;

        $calendarConst = $calendar === 'traditional' ? \IntlDateFormatter::TRADITIONAL : \IntlDateFormatter::GREGORIAN;

        $pattern = $this->getDateTimePattern(
            isset($datetype) ? $datetype : $dateFormat,
            isset($timetype) ? $timetype : $timeFormat,
            $calendarConst
        );

        return new \IntlDateFormatter(\Locale::getDefault(), $datetype, $timetype, null, $calendarConst, $pattern);
    }

    /**
     * Format the date/time value as a string based on the current locale
     *
     * @param string|false $format 'short', 'medium', 'long', 'full', 'none' or false
     *
     * @return int|null
     */
    public function getFormat($format)
    {
        if ($format === false) {
            $format = 'none';
        }

        $types = [
            'none'   => \IntlDateFormatter::NONE,
            'short'  => \IntlDateFormatter::SHORT,
            'medium' => \IntlDateFormatter::MEDIUM,
            'long'   => \IntlDateFormatter::LONG,
            'full'   => \IntlDateFormatter::FULL
        ];

        return isset($types[$format]) ? $types[$format] : null;
    }

    /**
     * Get the date/time pattern.
     *
     * @param int|string $datetype
     * @param int|string $timetype
     * @param int        $calendar
     *
     * @return string
     */
    public function getDateTimePattern($datetype, $timetype, $calendar = \IntlDateFormatter::GREGORIAN)
    {
        if (is_int($datetype) && is_int($timetype)) {
            return null;
        }

        return $this->getDatePattern(
            isset($datetype) ? $datetype : \IntlDateFormatter::SHORT,
            isset($timetype) ? $timetype : \IntlDateFormatter::SHORT,
            $calendar
        );
    }

    /**
     * Get the formatter to create a date and/or time pattern
     *
     * @param int|string $datetype
     * @param int|string $timetype
     * @param int        $calendar
     *
     * @return \IntlDateFormatter
     */
    public function getDatePatternFormatter($datetype, $timetype, $calendar = \IntlDateFormatter::GREGORIAN)
    {
        return \IntlDateFormatter::create(
            \Locale::getDefault(),
            is_int($datetype) ? $datetype : \IntlDateFormatter::NONE,
            is_int($timetype) ? $timetype : \IntlDateFormatter::NONE,
            \IntlTimeZone::getGMT(),
            $calendar
        );
    }

    /**
     * Get the date and/or time pattern
     * Default date pattern is short date pattern with 4 digit year.
     *
     * @param int|string $datetype
     * @param int|string $timetype
     * @param int        $calendar
     *
     * @return string
     */
    public function getDatePattern($datetype, $timetype, $calendar = \IntlDateFormatter::GREGORIAN)
    {
        $createPattern =
            (is_int($datetype) && $datetype !== \IntlDateFormatter::NONE) ||
            (is_int($timetype) && $timetype !== \IntlDateFormatter::NONE);

        $pattern = $createPattern ? $this->getDatePatternFormatter($datetype, $timetype, $calendar)->getPattern() : '';

        return trim(
            (is_string($datetype) ? $datetype . ' ' : '') .
            preg_replace('/\byy?\b/', 'yyyy', $pattern) .
            (is_string($timetype) ? ' ' . $timetype : '')
        );
    }

    /**
     * Format the date and/or time value as a string based on the current locale
     *
     * @param \DateTime|int|string $value
     * @param string               $dateFormat null, 'short', 'medium', 'long', 'full' or pattern
     * @param string               $timeFormat null, 'short', 'medium', 'long', 'full' or pattern
     * @param string               $calendar   'gregorian' or 'traditional'
     *
     * @return string
     */
    public function formatLocal($value, $dateFormat, $timeFormat, $calendar = 'gregorian')
    {
        if (!isset($value)) {
            return null;
        }

        $date      = $this->valueToDateTime($value);
        $formatter = $this->getDateFormatter($dateFormat, $timeFormat, $calendar);

        return $formatter->format($date->getTimestamp());
    }
}