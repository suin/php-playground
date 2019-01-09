<?php

declare(strict_types=1);

namespace Suin\Playground\PhpUnitDataProviderPerformance;

use PHPUnit\Framework\TestCase;

final class UsingLoopTest extends TestCase
{
    public function test_true(): void
    {
        foreach ($this->trues() as $value) {
            self::assertTrue($value);
        }
    }

    public function trues(): iterable
    {
        for ($count = 1; $count <= 1000; $count++) {
            yield true;
        }
    }
}
