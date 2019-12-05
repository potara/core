<?php

namespace Potara\Core\Crud\Entity;

interface ConvertToInterface
{
    /**
     * @param $value
     */
    public function toPHP(&$value): void;

    /**
     * @param $value
     */
    public function toDB(&$value): void;
}
