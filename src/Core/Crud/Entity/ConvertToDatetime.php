<?php

namespace Potara\Core\Crud\Entity;

use Potara\Core\Crud\AbstractEntity;

final class ConvertToDatetime extends AbstractConvertTo implements ConvertToInterface
{

    public function __construct(AbstractEntity &$entity, &$options = null)
    {
        $options = $this->factoryOptions([
            'format' => empty($options['format']) ? 'Y-m-d H:i:s' : $options['format']
        ], $options);

        parent::__construct($entity, $options);
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
