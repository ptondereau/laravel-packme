<?php

namespace Ptondereau\Tests\PackMe;

/**
 * Class TestCase.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object       &$object    Instantiated object that we will run method on.
     * @param string       $methodName Method name to call
     * @param string|array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, $parameters)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        if (is_array($parameters)) {
            return $method->invokeArgs($object, $parameters);
        }

        return $method->invoke($object, $parameters);
    }
}
