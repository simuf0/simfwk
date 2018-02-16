<?php

namespace Tests\SimFWKLib\Factory;

use PHPUnit\Framework\TestCase;

class SingletonClass {
    use \SimFWKLib\Factory\Singleton;
}

class SingletonTest extends TestCase
{
    /**
     * @expectedException Error
     */
    public function test_is_not_instanciable_with_new_operator ()
    {
        $instance = new SingletonClass;
    }

    public function test_is_instanciable_with_getInstanceOf_method ()
    {

        $instance = SingletonClass::getInstance();
        $this->assertInstanceOf(
            SingletonClass::class,
            $instance
        );
        return $instance;
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     */
    public function test_is_instanciable_twice ()
    {
        $instance = SingletonClass::getInstance();
        $this->assertInstanceOf(
            SingletonClass::class,
            $instance
        );
        return $instance;
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     * @expectedException Error
     */
    public function test_is_not_clonable ($instance)
    {
        clone $instance;
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     * @depends test_is_instanciable_twice
     */
    public function test_instances_have_same_type ($instance1, $instance2)
    {
        $this->assertEquals($instance1, $instance2);
        $this->assertTrue($instance1 instanceof SingletonClass);
        $this->assertTrue($instance2 instanceof SingletonClass);
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     * @depends test_is_instanciable_twice
     */
    public function test_instances_have_same_id ($instance1, $instance2)
    {
        $this->assertTrue($instance1 === $instance2);
        $this->assertTrue($instance1 instanceof SingletonClass);
        $this->assertTrue($instance2 instanceof SingletonClass);
    }
}