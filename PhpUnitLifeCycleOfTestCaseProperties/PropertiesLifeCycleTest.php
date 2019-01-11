<?php

declare(strict_types=1);

namespace Suin\Playground\PhpUnitLifeCycleOfTestCaseProperties;

use PHPUnit\Framework\TestCase;

final class PropertiesLifeCycleTest extends TestCase
{
    private const INITIALIZED = 1;

    private const MUTATED = 2;

    /**
     * @var int
     */
    private $property = self::INITIALIZED;

    public function test1(): void
    {
        self::assertSame(self::INITIALIZED, $this->property);
        $this->property = self::MUTATED;
        self::assertSame(self::MUTATED, $this->property);
    }

    public function test2(): void
    {
        self::assertSame(self::INITIALIZED, $this->property);
        $this->property = self::MUTATED;
        self::assertSame(self::MUTATED, $this->property);
    }

    /**
     * @testWith [1]
     *           [2]
     *           [3]
     */
    public function test3(): void
    {
        self::assertSame(self::INITIALIZED, $this->property);
        $this->property = self::MUTATED;
        self::assertSame(self::MUTATED, $this->property);
    }

    /**
     * @dataProvider getData
     */
    public function test4(): void
    {
        self::assertSame(self::INITIALIZED, $this->property);
        $this->property = self::MUTATED;
        self::assertSame(self::MUTATED, $this->property);
    }

    public function getData(): iterable
    {
        yield from [[1], [2], [3]];
    }
}
