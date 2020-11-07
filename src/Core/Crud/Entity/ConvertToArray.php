<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud\Entity;

final class ConvertToArray extends AbstractConvertTo implements ConvertToInterface
{

    public function toPHP(&$value, $delimitador = ","): void
    {
        if (is_null($value) || empty($value)) {
            $value = $this->default;
        } else {
            $delimitador = empty($delimitador) ? "," : $delimitador;
            $newArray    = explode($delimitador, $value);
            $value = is_array($newArray)?$newArray:[$newArray];

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
