<?php

namespace Tests\SimFWKLib;

use PHPUnit\Framework\TestCase;

class BootloaderTest extends TestCase
{
    private $instance;
    
    public function setUp ()
    {
        $this->instance = \SimFWKLib\Bootloader::getInstance();
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

    public function testCanLaunchApplication ()
    {
        $this->instance->launch("core");
        $this->assertContains($_SESSION, "app");
    }

    /**
     * @expectedException SimFWKLib\BootloaderException
     */
    public function testThrowExceptionIfCannotLoadApplication ()
    {
        $this->instance->launch("wrongApp");
    }
}