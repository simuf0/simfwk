<?php

namespace Tests\SimFWKLib\Utils;

use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    private $instance;
    
    public function setUp ()
    {
        $this->instance = \SimFWKLib\Utils\Cache::getInstance();
    }
    
    public function tearDown ()
    {
        $this->instance = null;
    }

    public function testIsFinal ()
    {
        $r = new \ReflectionClass($this->instance);
        $this->assertTrue($r->isFinal());
    }

    public function testIsInstance ()
    {
        $r = new \ReflectionClass($this->instance);
        $this->assertContains(
            "SimFWKLib\Factory\Instance",
            $r->getTraitNames()
        );
    }

    public function testCanGetContent ()
    {
        // $this->instance->put("server-message", "Hello World !", 60);
        var_dump($this->instance->get());
    }
}