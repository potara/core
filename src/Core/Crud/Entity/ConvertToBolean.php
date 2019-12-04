<?php

namespace Potara\Core\Crud\Entity;

class ConvertToBolean implements ConvertToInterface
{
    /**
     * @param $value
     * @return bool
     */
    static function toPHP($value): bool
    {
        return is_null($value) ? null : (bool)$value;
    }

    /**
     * @param $value
     * @return int
     */
    static function toDB($value): Integer
    {
        return (int)$value;
    }
}
