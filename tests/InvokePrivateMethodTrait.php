<?php

namespace Tests;

use ReflectionClass;
use ReflectionMethod;

trait InvokePrivateMethodTrait
{
    private function invokePrivateMethod($object, string $method, array $args = [])
    {
        $method = $this->setMethodToPublic($object, $method);

        return $method->invokeArgs($object, $args);
    }

    private function setMethodToPublic($object, $method): ReflectionMethod
    {
        $class = new ReflectionClass($object);
        $privateMethod = $class->getMethod($method);
        $privateMethod->setAccessible(true);

        return $privateMethod;
    }
}
