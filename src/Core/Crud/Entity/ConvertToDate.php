<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToDate implements ConvertToInterface
{
    protected $options;

    public function __construct($options = null)
    {
        $this->options = [
            'format' => empty($options['format']) ? 'Y-m-d' : $options['format']
        ];
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        (new ConvertToDatetime($this->options))->toPHP($value);
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        (new ConvertToDatetime($this->options))->toDB($value);
    }
}
