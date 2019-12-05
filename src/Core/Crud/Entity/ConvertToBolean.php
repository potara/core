<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToBolean implements ConvertToInterface
{
    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = is_null($value) ? null : (bool)$value;
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = (int)$value;
    }
}
