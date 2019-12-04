<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToDate implements ConvertToInterface
{
    /**
     * @param $value
     * @param string $format
     * @return \DateTime
     */
    static function toPHP($value, $format = 'Y-m-d'): \DateTime
    {
        return ConvertToDatetime::toPHP($value, $format);
    }

    /**
     * @param $value
     * @param string $format
     * @return string
     */
    static function toDB($value, $format = 'Y-m-d'): string
    {
        return ConvertToDatetime::toDB($value, $format);
    }
}
