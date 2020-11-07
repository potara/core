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
use Ramsey\Uuid\Uuid;

final class ConvertToUuid extends AbstractConvertTo implements ConvertToInterface
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
        if(empty($value)){
            $value = Uuid::uuid4()->toString();
        }
    }
}
