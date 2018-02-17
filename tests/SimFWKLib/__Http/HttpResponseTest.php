<?php

namespace Tests\SimFWKLib\Http;

use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{
    private $instance;
    
    public function setUp ()
    {
        $this->instance = \SimFWKLib\Http\HttpResponse::getInstance();
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

    /**
     * @runInSeparateProcess
     */
    public function testCanAddHeader ()
    {
        $this->assertNull(
            $this->instance->addHeader("Content-Type: text/plain")
        );
    }
}