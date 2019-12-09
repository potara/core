<?php


namespace Potara\Core\Crud\tests;

use Potara\Core\Crud\AbstractEntity;

class EntitySample extends AbstractEntity
{
    /**
     * @var type=integer
     */
    public $id;
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
