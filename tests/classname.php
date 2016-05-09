<?php

/*
 * Copyright ©2016 Michael D Johnson
 * Licensed under the MIT license (see LICENSE.md)
 */

namespace Test\It\Out;

use Really\Long\Sample\NestedNamespace\To\Just\Really\Test\Things\Out\MyClass;

const ITERATIONS = 10000000;

$di = new DI;

echo "Testing strings\n";
$timeString = new Timer;
for ($i = 0; $i < ITERATIONS; $i++) {
    $di->set(
        "Really\Long\Sample\NestedNamespace\To\Just\Really\Test\Things\Out\MyClass",
        "Really\Long\Sample\NestedNamespace\To\Just\Really\Test\Things\Out\MyClass"
    );
}
echo "    Strings elapsed: ", $timeString->stop(), "\n";

echo "Testing full namespace ::class\n";
$timeFullNS = new Timer;
for ($i = 0; $i < ITERATIONS; $i++) {
    $di->set(
        \Really\Long\Sample\NestedNamespace\To\Just\Really\Test\Things\Out\MyClass::class,
        \Really\Long\Sample\NestedNamespace\To\Just\Really\Test\Things\Out\MyClass::class
    );
}
echo "    Full NS ::class elapsed: ", $timeFullNS->stop(), "\n";

echo "Testing short namespace ::class\n";
$timeShortNS = new Timer;
for ($i = 0; $i < ITERATIONS; $i++) {
    $di->set(MyClass::class, MyClass::class);
}
echo "    Short NS ::class elapsed: ", $timeFullNS->stop(), "\n";

echo "\nDone.\n";

// Standin for dependency injection...
class DI
{
    public function set($name, $what)
    {
        return true;
    }
}

class Timer
{
    protected $startTime;
    protected $endTime;
    protected $complete;

    public function __construct()
    {
        $this->startTime = microtime(true);
        $this->complete = false;
    }

    public function stop()
    {
        $this->endTime = microtime(true);
        $this->complete = true;

        return $this->getElapsedTime();
    }

    public function getElapsedTime()
    {
        if (!$this->complete) {
            return microtime(true) - $this->startTime;
        }

        return $this->endTime - $this->startTime;
    }
}
