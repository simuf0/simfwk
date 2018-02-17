<?php

namespace Tests\SimFWKLib\Core;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private $filename;
    
    public function setUp ()
    {
        $this->filename = PATHS['tests'] . DS . "routes.json";
        $this->bad_json = PATHS['tests'] . DS . "bad_json.json";
    }
    
    public function tearDown ()
    {
        $this->filename = null;
        $this->bad_json = null;
    }

    public function test_is_final ()
    {
        $r = new \ReflectionClass(\SimFWKLib\Core\Router::class);
        $this->assertTrue($r->isFinal());
    }

    public function test_is_singleton ()
    {
        $r = new \ReflectionClass(\SimFWKLib\Core\Router::class);
        $this->assertContains(
            "SimFWKLib\Factory\Singleton",
            $r->getTraitNames()
        );
    }

    /**
     * @expectedException SimFWKLib\Core\RouterException
     * @expectedExceptionMessageRegExp /^Failed loading router : missing file/
     */
    public function test_throw_exception_if_route_file_is_missing ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            "missing_file.json",
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
    }

    /**
     * @expectedException SimFWKLib\Core\RouterException
     * @expectedExceptionMessageRegExp /^Failed loading router : error parsing json/
     */
    public function test_throw_exception_if_is_not_json_route_file ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            $this->bad_json,
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
    }

    public function test_exists_route ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            $this->filename,
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
        $this->assertInternalType("bool", $instance->exists("/"));
        $this->assertInternalType("bool", $instance->exists("/wrong"));
        $this->assertTrue($instance->exists("/"));
        $this->assertFalse($instance->exists("/wrong"));
    }

    public function test_can_insert_new_route ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            $this->filename,
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
        $this->assertFalse($instance->exists("/controller1/action1"));
        $instance->insert("/controller1/action1", "myController", "myAction");
        $this->assertTrue($instance->exists("/controller1/action1"));
        $instance->delete("/controller1/action1");
    }

    public function test_can_update_existing_route ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            $this->filename,
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
        $instance->insert("/controller1/action1", "myController", "myAction");
        $this->assertTrue($instance->exists("/controller1/action1"));
        $instance->update("/controller1/action1", "myController2", "myAction2");
        $this->assertContains("myController2", $instance->get("/controller1/action1"));
        $this->assertContains("myAction2", $instance->get("/controller1/action1"));
        $instance->delete("/controller1/action1");
    }

    public function test_can_delete_existing_route ()
    {
        $instance = \SimFWKLib\Core\Router::getInstance(
            $this->filename,
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
        $instance->insert("/controller1/action1", "myController", "myAction");
        $this->assertTrue($instance->exists("/controller1/action1"));
        $instance->delete("/controller1/action1");
        $this->assertFalse($instance->exists("/controller1/action1"));
    }

    public function test_is_expected_current_uri ()
    {
        // $stub = $this->createMock(\SimFWKLib\Http\HttpRequest::class);
        // $stub->staticMethod("uri")
        //      ->willReturn("/controller1/action2");

        // $instance = \SimFWKLib\Core\Router::getInstance(
        //     $this->filename,
        //     $stub
        // );
        // $this->assertTrue($instance->isCurrent("/controller1/action1"));
    }
}