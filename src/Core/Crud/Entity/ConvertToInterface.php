<?php

namespace Potara\Core\Crud\Entity;

interface ConvertToInterface
{
    static function toPHP($value);

    static function toDB($value);
}
