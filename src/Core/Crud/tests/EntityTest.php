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

class EntityTest extends TestCase
{

    public function testEntity()
    {
        $this->assertEquals("asb", 'asb');
    }
}