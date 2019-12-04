<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToDatetime implements ConvertToInterface
{
    /**
     * @param $value
     * @param string $format
     * @return \DateTime
     */
    static function toPHP($value, $format = 'Y-m-d H:i:s'): \DateTime
    {
        if (!is_null($value)) {
            $newDateTime = \DateTime::createFromFormat($format, $value);
            if ($newDateTime) {
                return $newDateTime;
            }
        }
        return $value;
    }

    /**
     * @param $value
     * @param string $format
     * @return string
     */
    static function toDB($value, $format = 'Y-m-d H:i:s'): string
    {
        return $value instanceof \DateTime ? $value->format($format) : $value;
    }
}
