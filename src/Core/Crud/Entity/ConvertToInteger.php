<?php

namespace Potara\Core\Crud\Entity;

class ConvertToInteger implements ConvertToInterface
{
    /**
     * @param $value
     * @return int
     */
    static function toPHP($value): Integer
    {
        return (int)$value;
    }

    /**
     * @param $value
     * @return int
     */
    static function toDB($value): Integer
    {
        return self::toPHP($value);
    }
}
