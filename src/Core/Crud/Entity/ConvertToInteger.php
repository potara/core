<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToInteger extends AbstractConvertTo implements ConvertToInterface
{
    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = (int)$value;
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $this->toPHP($value);
    }
}
