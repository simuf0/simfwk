<?php

namespace Tests\SimFWKLib\Factory;

use PHPUnit\Framework\TestCase;

class InstanceClass {
    use \SimFWKLib\Factory\Instance;
}

class InstanceTest extends TestCase
{
    public function test_is_instanciable_with_new_operator ()
    {
        $instance = new InstanceClass;
        $this->assertInstanceOf(
            InstanceClass::class,
            $instance
        );
    }
    public function test_is_instanciable_with_getInstanceOf_method ()
    {

        $instance = InstanceClass::getInstance();
        $this->assertInstanceOf(
            InstanceClass::class,
            $instance
        );
        return $instance;
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     */
    public function test_is_instanciable_twice ()
    {
        $instance = InstanceClass::getInstance();
        $this->assertInstanceOf(
            InstanceClass::class,
            $instance
        );
        return $instance;
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     */
    public function test_is_clonable ($instance)
    {
        $this->assertEquals($instance, clone $instance);
        $this->assertFalse($instance === clone $instance);
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     * @depends test_is_instanciable_twice
     */
    public function test_instances_have_same_type ($instance1, $instance2)
    {
        $this->assertEquals($instance1, $instance2);
        $this->assertTrue($instance1 instanceof InstanceClass);
        $this->assertTrue($instance2 instanceof InstanceClass);
    }

    /**
     * @depends test_is_instanciable_with_getInstanceOf_method
     * @depends test_is_instanciable_twice
     */
    public function test_instances_have_different_id ($instance1, $instance2)
    {
        $this->assertFalse($instance1 === $instance2);
        $this->assertTrue($instance1 instanceof InstanceClass);
        $this->assertTrue($instance2 instanceof InstanceClass);
    }
}