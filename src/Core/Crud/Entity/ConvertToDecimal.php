<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToDecimal implements ConvertToInterface
{
    protected $options;

    public function __construct($options = null)
    {
        $this->options = [
            'decimals' => empty($options['decimals']) ? 0 : (int)$options['decimals'],
            'dp'       => empty($options['dp']) ? '.' : (int)$options['dp'],
            'ts'       => empty($options['ts']) ? ',' : (int)$options['ts'],
        ];
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $options = $this->options;
        $value   = empty($options) ? (float)$value : (float)number_format($value, $options['decimals'], $options['dp'], $options['ts']);
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = empty($value) ? $value : (float)number_format($value, $this->options['decimals'], '.', '');
    }
}
