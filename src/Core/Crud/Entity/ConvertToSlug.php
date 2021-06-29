<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud\Entity;

use Potara\Core\Crud\AbstractEntity;
use Potara\Core\Lib\FacotrySlug;

final class ConvertToSlug extends AbstractConvertTo implements ConvertToInterface
{

    /**
     * @param $value
     */
    public function toPHP(&$value): void
    {
    }

    /**
     * @param $value
     */
    public function toDB(&$value): void
    {
        $stringName = $this->options['var'];
        if (!empty($stringName)) {
            $value = FacotrySlug::factory($this->entity->$stringName);
        } else {
            $value = null;
        }
    }
}
