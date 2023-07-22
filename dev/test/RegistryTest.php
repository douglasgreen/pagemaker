<?php

use PageMaker\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    public function testDelete()
    {
        $registry = new Registry();
        $registry->set('key1', 'int', 123);
        $registry->delete('key1');

        $this->assertFalse($registry->has('key1'));
    }

    public function testGetNonexistentKey()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No entry for key key1');

        $registry = new Registry();
        $registry->get('key1');
    }

    public function testHas()
    {
        $registry = new Registry();
        $registry->set('key1', 'int', 123);

        $this->assertTrue($registry->has('key1'));
        $this->assertFalse($registry->has('key2'));
    }

    public function testSetAndGetValidValue()
    {
        $registry = new Registry();
        $registry->set('key1', 'int', 123);
        $this->assertEquals(123, $registry->get('key1'));
    }

    public function testSetExistingKey()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('There is already an entry for key key1');

        $registry = new Registry();
        $registry->set('key1', 'int', 123);
        $registry->set('key1', 'int', 456);
    }

    public function testSetInvalidTypeValue()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid type for key key1. Expected int, got string');

        $registry = new Registry();
        $registry->set('key1', 'int', 'invalid');
    }
}
