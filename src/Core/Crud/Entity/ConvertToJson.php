<?php

namespace Potara\Core\Crud\Entity;

use Potara\Core\Crud\AbstractEntity;

final class ConvertToJson extends AbstractConvertTo implements ConvertToInterface
{
    public function __construct(AbstractEntity &$entity, &$options = null)
    {
        $options = $this->factoryOptions([
            'assoc'   => is_bool($options['assoc']) ? $options['assoc'] : true,
            'depth'   => empty($options['depth']) ? 512 : (int)$options['depth'],
            'options' => empty($options['options']) ? 0 : $options['options'],
        ], $options);
        parent::__construct($entity, $options);
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        $value = is_string($value) ? json_decode($value, $this->options['assoc'], $this->options['depth'], $this->options['options']) : $value;
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = is_array($value) ? json_encode($value, $this->options['options'], $this->options['depth']) : null;
    }
}
