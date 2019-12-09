<?php

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
