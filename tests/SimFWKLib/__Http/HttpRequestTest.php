<?php

namespace Tests\SimFWKLib\Http;

use PHPUnit\Framework\TestCase;

session_start();

class HttpRequestTest extends TestCase
{
    const EXPECTED_URI = "/index.php";

    private $instance;
    
    public function setUp ()
    {
        $provider = ['var' => "val"];
        $_GET += $provider;
        $_POST += $provider;
        $_SESSION += $provider;
        $_FILES += $provider;
        $_COOKIE += $provider;
        $_SERVER['REQUEST_URI'] = self::EXPECTED_URI;
        $this->instance = \SimFWKLib\Http\HttpRequest::getInstance();
    }
    
    public function tearDown ()
    {
        unset($_SERVER['REQUEST_URI']);
        $this->instance = null;
    }

    public function provider ()
    {
        return [[["var" => "val"]]];
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

    public function testReturnExpectedUri ()
    {
        $this->assertEquals(
            \SimFWKLib\Http\HttpRequest::uri(),
            self::EXPECTED_URI
        );
    }

    /**
     * @dataProvider provider
     */
    public function testReturnDataGet ($provider)
    {
        $this->assertEquals($this->instance->dataGet(), $provider);
        $this->assertEquals($this->instance->dataGet("var"),"val");
        $this->assertFalse($this->instance->dataGet("invalid_var"));
        $this->instance->get += ['var2' => "val2"];
        $this->assertTrue(($this->instance->dataGet()) === $_GET);
    }

    /**
     * @dataProvider provider
     */
    public function testReturnDataPost ($provider)
    {
        $this->assertEquals($this->instance->dataPost(), $provider);
        $this->assertEquals($this->instance->dataPost("var"), "val");
        $this->assertFalse($this->instance->dataPost("invalid_var"));
        $this->instance->post += ['var2' => "val2"];
        $this->assertTrue(($this->instance->dataGet()) === $_POST);
    }
    
    /**
     * @dataProvider provider
     */
    public function testReturnDataSession ($provider)
    {
        $this->assertEquals($this->instance->dataSession(), $provider);
        $this->assertEquals($this->instance->dataSession("var"), "val");
        $this->assertFalse($this->instance->dataSession("invalid_var"));
        $this->instance->session += ['var2' => "val2"];
        $this->assertTrue(($this->instance->dataSession()) === $_SESSION);
    }
    
    /**
     * @dataProvider provider
     */
    public function testReturnDataFiles ($provider)
    {
        $this->assertEquals($this->instance->dataFiles(), $provider);
        $this->assertEquals($this->instance->dataFiles("var"), "val");
        $this->assertFalse($this->instance->dataFiles("invalid_var"));
        $this->instance->files += ['var2' => "val2"];
        $this->assertFalse(($this->instance->dataFiles()) === $_FILES);
    }
    
    /**
     * @dataProvider provider
     */
    public function testReturnDataCookie ($provider)
    {
        $this->assertEquals($this->instance->dataCookie(), $provider);
        $this->assertEquals($this->instance->dataCookie("var"), "val");
        $this->assertFalse($this->instance->dataCookie("invalid_var"));
        $this->instance->cookie += ['var2' => "val2"];
        $this->assertFalse(($this->instance->dataCookie()) === $_FILES);
    }
}