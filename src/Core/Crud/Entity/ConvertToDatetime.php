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
    public function toPHP(&$value) : void
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
    public function toDB(&$value) : void
    {
        $action = $this->options['action'];

        if ($action == 'start') {
            $value = is_null($value) ? (new \DateTime('now'))->format($this->options['format']) : $value;
        }
        if ($action == 'reload') {
            $value = new \DateTime('now');
        }

        $value = $value instanceof \DateTime ? $value->format($this->options['format']) : $value;

    }
}
