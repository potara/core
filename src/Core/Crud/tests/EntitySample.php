<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

namespace Potara\Core\Crud\tests;

use Potara\Core\Crud\AbstractEntity;

class EntitySample extends AbstractEntity
{
    /**
     * @var type=integer
     */
    public $id;

    /**
     * @var type=uuid
     */
    public $uuid;

    /**
     * @var type=string
     */
    public $name;

    /**
     * @var type=slug&var=name
     */
    public $slug;
    /**
     * @var type=datetime
     */
    public $date;
    /**
     * @var type=decimal&decimals=3
     */
    public $money;

    /**
     * @var type=decimal&decimals=2
     */
    public $total;

    public $notype;

    /**
     * @var type=serialize
     */
    public $serialize;

    /**
     * @var type=bolean
     */
    public $status;

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

}