<?php

namespace Potara\Core\Crud\Entity;

class ConvertToSerializer implements ConvertToInterface
{
    /**
     * @param $value
     * @return mixed|array
     */
    static function toPHP($value)
    {
        return is_null($value) ? $value : unserialize($value);
    }

    /**
     * @param $value
     * @return string
     */
    static function toDB($value)
    {
        return is_array($value) ? serialize($value) : $value;
    }
}
