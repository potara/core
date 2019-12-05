<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToSerialize implements ConvertToInterface
{
    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = empty($value) ? $value : unserialize($value);
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = is_array($value) ? serialize($value) : $value;
    }
}
