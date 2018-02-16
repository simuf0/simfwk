<?php

namespace Tests\SimFWKLib\Factory;

use PHPUnit\Framework\TestCase;

class ThrowerClass {
    use \SimFWKLib\Factory\Thrower;
}

class ThrowerClassWithOutException {
    use \SimFWKLib\Factory\Thrower;
}

class ThrowerClassException extends \Exception {
    const E_TEST = "This is a testing exception";
}

class ThrowerTest extends TestCase
{
    /**
     * @expectedException Tests\SimFWKLib\Factory\ThrowerClassException
     * @expectedExceptionMessage This is a testing exception
     */
    public function test_is_throwing_exception ()
    {
        $r = new \ReflectionClass(new ThrowerClass);
        $method = $r->getMethod("throws");
        $method->setAccessible(true);
        $method->invoke(new ThrowerClass, "E_TEST");
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessageRegExp /^Failed throwing exception : missing class/
     */
    public function test_throw_exception_if_class_not_exist ()
    {
        $r = new \ReflectionClass(new ThrowerClassWithOutException);
        $method = $r->getMethod("throws");
        $method->setAccessible(true);
        $method->invoke(new ThrowerClassWithOutException, "E_TEST");
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessageRegExp /^Failed throwing exception : missing constant/
     */
    public function test_throw_exception_if_message_not_exist ()
    {
        $r = new \ReflectionClass(new ThrowerClass);
        $method = $r->getMethod("throws");
        $method->setAccessible(true);
        $method->invoke(new ThrowerClass, "E_NOT_EXISTING_MESSAGE");
    }
}