<?php

namespace Potara\Core\Crud\Entity;

final class ConvertToDatetime implements ConvertToInterface
{

    protected $options;

    public function __construct($options = null)
    {
        $this->options = [
            'format' => empty($options['format']) ? 'Y-m-d H:i:s' : $options['format']
        ];
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        if (!is_null($value)) {
            $newDateTime = \DateTime::createFromFormat($this->options['format'], $value);
            if ($newDateTime) {
                $value = $newDateTime;
            }
        }
    }


    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = $value instanceof \DateTime ? $value->format($this->options['format']) : $value;
    }
}
