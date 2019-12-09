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

use Potara\Core\Crud\AbstractEntity;

final class ConvertToDate extends AbstractConvertTo implements ConvertToInterface
{
    public function __construct(AbstractEntity &$entity, &$options = [])
    {
        $options = $this->factoryOptions([
            'format' => empty($options['format']) ? 'Y-m-d' : $options['format']
        ], $options);
        parent::__construct($entity, $options);
    }

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
        (new ConvertToDatetime($this->entity, $this->options))->toPHP($value);
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        (new ConvertToDatetime($this->entity, $this->options))->toDB($value);
    }
}
