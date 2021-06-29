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

use Potara\Core\Crud\AbstractEntity;

final class ConvertToDecimal extends AbstractConvertTo implements ConvertToInterface
{
    public function __construct(AbstractEntity &$entity, &$options = [])
    {
        $options = $this->factoryOptions([
            'decimals' => empty($options['decimals']) ? 0 : (int)$options['decimals'],
            'dp'       => empty($options['dp']) ? '.' : (int)$options['dp'],
            'ts'       => empty($options['ts']) ? ',' : (int)$options['ts'],
        ], $options);
        parent::__construct($entity, $options);
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $options = $this->options;
        $value   = empty($value) ? $this->default : $value;

        if(is_string($value) || is_float($value)){
            $value = empty($options) ? (float)$value : (float)number_format($value, $options['decimals'], $options['dp'], $options['ts']);
        }
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = empty($value) ? $this->default : $value;

        $value = (is_string($value) || is_float($value)) ? (float)number_format($value, $this->options['decimals'], '.', '') : $value;
    }
}
