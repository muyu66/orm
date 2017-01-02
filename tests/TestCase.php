<?php

namespace TestCase;

use PHPUnit_Framework_TestCase;
use ReflectionMethod;
use Exception;

class TestCase extends PHPUnit_Framework_TestCase
{
    public function getPrivate($class, $func, $params = null)
    {
        if (is_string($params)) {
            $params = [$params];
        }
        $ctl = new ReflectionMethod($class, $func);
        $ctl->setAccessible(true);
        return $ctl->invokeArgs(new $class(), $params);
    }

    public function assertException($func, $code)
    {
        try {
            $func();
            $result = false;
        } catch (Exception $e) {
            if ($e->getCode() === $code) {
                $result = true;
            } else {
                $result = false;
            }
        }
        $this->assertTrue($result);
    }
}
