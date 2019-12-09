<?php

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
