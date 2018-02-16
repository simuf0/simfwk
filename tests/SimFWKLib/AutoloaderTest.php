<?php

namespace Tests\SimFWKLib;

use PHPUnit\Framework\TestCase;

class AutoloaderTest extends TestCase
{
    private $instance;
    
    public function setUp ()
    {
        $this->instance = \SimFWKLib\Autoloader::getInstance();
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

    public function testIsSingleton ()
    {
        $r = new \ReflectionClass($this->instance);
        $this->assertContains(
            "SimFWKLib\Factory\Singleton",
            $r->getTraitNames()
        );
    }

    public function testCanLoadClass ()
    {
        $class = "SimFWKLib\Bootloader";
        $this->assertInstanceOf($class, $class::getInstance());
    }

    /**
     * @expectedException SimFWKLib\AutoloaderException
     */
    public function testCannotLoadClass ()
    {
        $r = new \ReflectionClass($this->instance);
        $method = $r->getMethod("load");
        $method->setAccessible(true);
        $method->invoke($this->instance, "SimFWKLib\WrongClass");
    }
}