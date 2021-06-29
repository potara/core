<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */


namespace Potara\Core\Provider\Doctrine;


use Doctrine\DBAL\Connection;

class DoctrineRepository
{
    /** @var DoctrineEntity */
    protected $doctrineEntity;

    /** @var Connection  */
    public    $conn;
    public    $entity;
    public    $table;

    public function __construct(DoctrineEntity &$doctrineEntity)
    {
        $this->doctrineEntity = $doctrineEntity;
        $this->conn           = $this->doctrineEntity->conn;
    }
}