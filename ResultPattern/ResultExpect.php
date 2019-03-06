<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use PHPUnit\Framework\Assert;

/**
 * @template T
 */
final class ResultExpect extends Assert
{
    /**
     * @var Result
     * @psalm-var Result<T>
     */
    private $result;

    /**
     * @psalm-param Result<T> $result
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * @psalm-return ResultExpect<T>
     */
    public function toBeSuccess(): self
    {
        self::assertTrue($this->result->isSuccess());
        return $this;
    }

    /**
     * @psalm-return ResultExpect<T>
     */
    public function toBeFailure(): self
    {
        self::assertTrue($this->result->isFailure());
        return $this;
    }

    /**
     * @psalm-param T $expectedValue
     * @psalm-return ResultExpect<T>
     */
    public function valueToBe($expectedValue): self
    {
        self::assertSame($expectedValue, $this->result->get());
        return $this;
    }

    /**
     * @psalm-return ResultExpect<T>
     */
    public function exceptionMessageToBe(string $expectedMessage): self
    {
        self::assertSame(
            $expectedMessage,
            $this->result->getException()->getMessage()
        );
        return $this;
    }

    /**
     * @psalm-param class-string<\Exception> $class
     * @psalm-return ResultExpect<T>
     */
    public function exceptionTypeToBe(string $class): self
    {
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($class, $this->result->getException());
        return $this;
    }
}
