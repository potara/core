<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToArray implements ConvertToInterface
{

    public function toPHP(&$value, $delimitador = ","): void
    {
        if (is_null($value)) {
            $value = [];
        } else {
            $newArray = explode($delimitador, $value);
            if (is_string($newArray)) {
                $value = [$newArray];
            } else {
                $value = $newArray;
            }
        }
    }

    /**
     * @param $value
     * @param string $delimitador
     */
    public function toDB(&$value, $delimitador = ","): void
    {
        $value = (empty($value) || !is_array($value)) ? null : implode($delimitador, $value);
    }
}
