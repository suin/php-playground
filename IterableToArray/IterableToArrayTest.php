<?php

declare(strict_types=1);

namespace Suin\Playground\IterableToArray;

use PHPUnit\Framework\TestCase;
use Traversable;
use TypeError;

final class IterableToArrayTest extends TestCase
{
    /**
     * @test
     * @testdox The iterator_to_array throws TypeError when it got an array, since arrays are incompatible with Traversable.
     */
    public function iterator_to_array_and_array_iterable(): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(
            'Argument 1 passed to iterator_to_array() must implement '
            . 'interface Traversable, array given'
        );
        self::assertNotInstanceOf(Traversable::class, $this->arrayIterable());
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInternalType('array', $this->arrayIterable());
        /** @noinspection UnusedFunctionResultInspection */
        /** @noinspection PhpParamsInspection */
        \iterator_to_array($this->arrayIterable(), false);
    }

    /**
     * @test
     * @testdox The iterator_to_array works well when it got a Generator, since Generators are compatible with Traversable.
     */
    public function iterator_to_array_and_generator_iterable(): void
    {
        self::assertInstanceOf(Traversable::class, $this->generatorIterable());
        /** @noinspection PhpParamsInspection */
        $result = \iterator_to_array($this->generatorIterable(), false);
        self::assertSame([1, 2, 3], $result);
    }

    /**
     * @test
     */
    public function iterable_to_array_and_array_iterator(): void
    {
        self::assertSame(
            [1, 2, 3],
            $this->iterable_to_array($this->arrayIterable())
        );
    }

    /**
     * @test
     */
    public function iterable_to_array_and_generator_iterator(): void
    {
        self::assertSame(
            [1, 2, 3],
            $this->iterable_to_array($this->generatorIterable())
        );
    }

    private function arrayIterable(): iterable
    {
        return [1, 2, 3];
    }

    private function generatorIterable(): iterable
    {
        yield from [1, 2, 3];
    }

    private function iterable_to_array(iterable $iterable): array
    {
        $array = [];
        \array_push($array, ...$iterable);
        return $array;
    }
}
