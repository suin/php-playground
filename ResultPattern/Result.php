<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use Exception;

/**
 * @template T
 */
abstract class Result
{
    /**
     * Create a Success result.
     *
     * @template U
     * @psalm-param U $value
     * @psalm-return Result<U>
     *
     * @param $value mixed
     */
    final public static function success($value): self
    {
        return new Success($value);
    }

    /**
     * Create a Failure result
     *
     * @template U
     * @psalm-return Result<U>
     */
    final public static function failure(Exception $exception): self
    {
        return new Failure($exception);
    }

    /**
     * Returns true if the Result is a Failure, false otherwise.
     */
    abstract public function isFailure(): bool;

    /**
     * Returns true if the Result is a Success, false otherwise.
     */
    abstract public function isSuccess(): bool;

    /**
     * Returns the exception from this Failure or throws the
     * BadMethodCallException if this is a Success.
     *
     * @see \BadMethodCallException
     */
    abstract public function getException(): Exception;

    /**
     * Returns the value from this Success or throws the BadMethodCallException
     * if this is a Failure.
     *
     * @psalm-return T
     *
     * @see \BadMethodCallException
     */
    abstract public function get();

    /**
     * Maps the given function to the value from this Success or returns this
     * if this is a Failure.
     *
     * @template U
     * @psalm-param callable(T): U $transform
     * @psalm-return Result<U>
     */
    abstract public function map(callable $transform): self;

    /**
     * Applies the given function if this is a Failure, otherwise returns this
     * if this is Success.
     *
     * @psalm-param callable(\Exception):T|callable():T $rescueException
     * @psalm-return Result<T>
     */
    abstract public function recover(callable $rescueException): self;

    /**
     * Applies the given function if this is a Failure, otherwise returns this
     * if this is Success.
     *
     * @psalm-param callable(\Exception):self<T>|callable():self<T> $rescueException
     * @psalm-return Result<T>
     */
    abstract public function recoverWith(callable $rescueException): self;
}
