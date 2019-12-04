<?php
/**
 * This file is part of the Potara Framework (https://potara.org)
 *
 * @see       https://github.com/potara/core
 * @copyright Copyright (c) 2018-2019 Bruno Lima
 * @author    Bruno Lima <eu@brunolima.me>
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
            'name'      => 'Bruno Lima',
            'date'      => '2019-12-03 10:37:00',
            'money'     => '10.15',
            'serialize' => 'a:3:{s:4:"name";s:10:"Bruno Lima";s:4:"year";i:1985;s:6:"genere";s:1:"m";}',
            'status'    => '1'
        ]);
    }

    public function testEntity()
    {
        $entity = $this->getEntity();
        $this->assertIsInt($entity->id,'ID não é Inteiro');
        $this->assertIsString($entity->name,'Nome não é String');
        $this->assertIsArray($entity->serialize,'Serialize não é Array');
        $this->assertIsBool($entity->status,'Status não é Bolean');
        $this->assertTrue($entity->date instanceof \DateTime,'Data não é data');
    }
}
