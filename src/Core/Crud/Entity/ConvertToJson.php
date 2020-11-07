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
        $value = empty($value) ? $this->default : $value;
        $value = is_string($value) ? json_decode($value, $this->options['assoc'], $this->options['depth'], $this->options['options']) : $value;
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $value = empty($value) ? $this->default : $value;
        $value = is_array($value) ? json_encode($value, $this->options['options'], $this->options['depth']) : $value;

    }
}
