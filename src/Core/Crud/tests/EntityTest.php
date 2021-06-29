<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2021 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Potara\Core\Crud\tests\EntitySample;

class EntityTest extends TestCase
{

    protected function getEntity($data=[])
    {
        return new EntitySample(array_replace($data,[
            'id'        => '1',
            'name'      => 'Bruno Lima -abcç 132',
            'date'      => '2019-12-03 10:37:00',
            'money'     => '10.1555',
            'total'     => '546810.877615',
            'serialize' => 'a:3:{s:4:"name";s:10:"Bruno Lima";s:4:"year";i:1985;s:6:"genere";s:1:"m";}',
            'status'    => '1'
        ]));
    }

    public function testEntityToPHP()
    {
        $entity = $this->getEntity();
        $this->assertIsInt($entity->id, 'ID not integer');
        $this->assertNull($entity->uuid, 'uuid not null');
        $this->assertIsString($entity->name, 'name not string');
        $this->assertIsFloat($entity->money, 'money notfloat');
        $this->assertIsFloat($entity->total, 'total not float');
        $this->assertNull($entity->notype, 'notype not null');
        $this->assertIsArray($entity->serialize, 'serialize not array');
        $this->assertIsBool($entity->status, 'status not bolean');
        $this->assertTrue($entity->date instanceof \DateTime, 'data not datetime');
    }

    public function testEntityToDB()
    {
        $entity = $this->getEntity()->toSave();
        $this->assertIsInt($entity->id, 'ID not integer');
        $this->assertIsString($entity->uuid, 'uuid not string');
        $this->assertIsString($entity->name, 'name not string');
        $this->assertIsString($entity->slug, 'slug not string');
        $this->assertIsFloat($entity->money, 'money not string');
        $this->assertIsFloat($entity->total, 'total not string');
        $this->assertIsString($entity->serialize, 'serialize not string');
        $this->assertIsInt($entity->status, 'status not integer');
        $this->assertIsString($entity->date, 'date not string');
    }
}