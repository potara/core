<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud\Entity;

final class ConvertToBolean extends AbstractConvertTo implements ConvertToInterface
{
    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = is_null($value) ? $this->default : (bool)$value;
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = (int)$value;
    }
}
