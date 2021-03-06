<?php

declare(strict_types=1);

namespace LoopingExecTest;

use function LoopingExec\continuallyExecuteCallable;
use function LoopingExec\continuallyExecuteCallableEx;

/*
 * @coversNothing
 */
class FunctionsTest extends BaseTestCase
{
    public function testBasic()
    {
        $counter = 0;
        sleep(3);

        $fn = function () use (&$counter) {
            $counter += 1;
        };

        $lines = [];

        $logger = function (string $message) use (&$lines) {
            $lines[] = $message;
        };

        continuallyExecuteCallableEx(
            $fn,
            5,
            100,
            50,
            $logger
        );

        $this->assertGreaterThanOrEqual(40, $counter);
        $this->assertLessThanOrEqual(50, $counter);
    }
}
