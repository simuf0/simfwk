<?php

namespace Tests\SimFWKLib\Controllers;

use PHPUnit\Framework\TestCase;
use SimFWKLib\Controllers\ViewController;

class ViewControllerTest extends TestCase
{
    private $view;
    
    public function setUp ()
    {
        $this->setView();
        $this->setInstance($this->view);
    }
    
    public function tearDown ()
    {
        $this->view = null;
        $this->instance = null;
    }

    private function setView ()
    {
        $this->view = $this->getMockBuilder(\SimFWKLib\Core\View::class)
            ->disableOriginalConstructor()
            ->setMethods(["addVars", "render"])
            ->getMock();
        $this->view
            ->method("render")
            ->willReturn("passed");
    }

    private function setInstance ()
    {
        $this->instance = $this->getMockBuilder(ViewController::class)
            ->disableOriginalConstructor()
            ->setMethods([
                "setView",
                "executeSingleAction",
                "executeMultipleAction",
            ])
            ->getMock();

        $view = (new \ReflectionClass($this->instance))->getProperty("view");
        $view->setAccessible(true);
        $view->setValue($this->instance, $this->view);

        $this->instance
            ->method("setView")
            ->willReturn($this->view);
    }

    // public function test_can_execute_an_action ()
    // {
    //     $this->assertEquals(
    //         $this->instance->execute("singleAction"),
    //         "passed"
    //     );
    // }

    /**
     * @expectedException \SimFWKLib\ControllerException
     */
    public function test_throw_exception_if_cannot_execute_an_action ()
    {
        $this->instance->execute("wrong_action");
    }

    public function test_can_set_a_view ()
    {
    }

    /**
     * @expectedException \SimFWKLib\ControllerException
     */
    public function test_throw_exception_if_cannot_set_a_view ()
    {
    }
}