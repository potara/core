<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToArray implements ConvertToInterface
{
    /**
     * @param $value
     * @param string $delimitador
     * @return array
     */
    static function toPHP($value, $delimitador = ",")
    {
        if (is_null($value)) {
            return [];
        }

        $newArray = explode($delimitador, $value);
        if (is_string($newArray)) {
            return [$newArray];
        }

        return $newArray;
    }

    /**
     * @param $value
     * @param string $delimitador
     * @return string|null
     */
    static function toDB($value, $delimitador = ",")
    {
        return (empty($data) || !is_array($data)) ? null : implode($delimitador, $value);
    }
}
