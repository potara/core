<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToJson implements ConvertToInterface
{

    protected $options;

    public function __construct($options = null)
    {
        $this->options = [
            'assoc'   => is_bool($options['assoc']) ? $options['assoc'] : true,
            'depth'   => empty($options['depth']) ? 512 : (int)$options['depth'],
            'options' => empty($options['options']) ? 0 : $options['options'],
        ];
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
