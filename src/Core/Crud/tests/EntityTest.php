<?php
/**
 * This file is part of the Potara (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2020 Bruno Lima
 * @author    Bruno Lima <brunolimame@gmail.com>
 * @license   https://github.com/potara/core/blob/master/LICENSE (MIT License)
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Potara\Core\Crud\tests\EntitySample;

class EntityTest extends TestCase
{

    protected function getEntity()
    {
        return new EntitySample([
            'id'        => '1',
            'name'      => 'Bruno Lima -abcç 132',
            'date'      => '2019-12-03 10:37:00',
            'money'     => '10.1555',
            'total'     => '546810.877615',
            'serialize' => 'a:3:{s:4:"name";s:10:"Bruno Lima";s:4:"year";i:1985;s:6:"genere";s:1:"m";}',
            'status'    => '1'
        ]);
    }

    public function testEntityToPHP()
    {
        $entity = $this->getEntity();
        $this->assertIsInt($entity->id, 'ID não é Inteiro');
        $this->assertIsString($entity->name, 'Nome não é String');
        $this->assertIsFloat($entity->money, 'Money não é float');
        $this->assertIsFloat($entity->total, 'Total não é float');
        $this->assertIsArray($entity->serialize, 'Serialize não é Array');
        $this->assertIsBool($entity->status, 'Status não é Bolean');
        $this->assertTrue($entity->date instanceof \DateTime, 'Data não é data');
    }

    public function testEntityToDB()
    {
        $entity = $this->getEntity()->toSave();
        $this->assertIsInt($entity->id, 'ID não é Inteiro');
        $this->assertIsString($entity->name, 'Nome não é String');
        $this->assertIsString($entity->slug, 'Slug não é String');
        $this->assertIsFloat($entity->money, 'Money não é string');
        $this->assertIsFloat($entity->total, 'Total não é string');
        $this->assertIsString($entity->serialize, 'Serialize não é string');
        $this->assertIsInt($entity->status, 'Status não é inteiro');
        $this->assertIsString($entity->date, 'Data não é string');
    }
}
