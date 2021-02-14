<?php


namespace Potara\Core\Lib;


use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;

abstract class FactoryUuid
{
    static public function v1(): string
    {
        return Uuid::uuid1()
                   ->toString();
    }

    static public function v1Random($node = null): string
    {
        $node = empty($node) ? (new RandomNodeProvider())->getNode() : $node;
        return Uuid::uuid1($node)
                   ->toString();
    }

    static public function v2(): string
    {
        return Uuid::uuid2(Uuid::DCE_DOMAIN_PERSON)
                   ->toString();
    }

    static public function v3($ns, $value): string
    {
        return Uuid::uuid3($ns, $value)
                   ->toString();
    }

    static public function v4(): string
    {
        return Uuid::uuid4()
                   ->toString();
    }
}