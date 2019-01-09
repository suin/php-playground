<?php

declare(strict_types=1);

namespace Suin\Playground\PhpUnitDataProviderPerformance;

use PHPUnit\Framework\TestCase;

final class UsingDataProviderTest extends TestCase
{
    /**
     * @dataProvider trues
     * @group skip
     */
    public function test_true(bool $value): void
    {
        self::assertTrue($value);
    }

    public function trues(): iterable
    {
        for ($count = 1; $count <= 1000; $count++) {
            yield [true];
        }
    }
}
