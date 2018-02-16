<?php

namespace Tests\SimFWKLib\Wrappers;

use PHPUnit\Framework\TestCase;

class ArrayWrapperTest extends TestCase
{
    private $instance;
    
    public function setUp ()
    {
        $this->instance = \SimFWKLib\Wrappers\ArrayWrapper::getInstance();
    }
    
    public function tearDown ()
    {
        $this->instance = null;
    }

    public function test_isAssoc ()
    {
        $this->assertTrue(
            $this->instance->isAssoc(['name' => "value"])
        );
        $this->assertFalse(
            $this->instance->isAssoc(["value1", "value2"])
        );
        $this->expectException(\TypeError::class);
        $this->instance->isAssoc("incorrect_type");
    }
}