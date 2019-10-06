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

class SlugTest extends TestCase
{

    public function testSlug()
    {
        $slug = \Potara\Core\Lib\FacotrySlug::factory("Test Factory Slug");

        $this->assertEquals($slug, 'test-factory-slug');
    }

    public function testRemoveCaracter()
    {
        $slug = \Potara\Core\Lib\FacotrySlug::factory("aàAÁçIi oòÓ - ");

        $this->assertEquals($slug, 'aaaacii-ooo');
    }
}