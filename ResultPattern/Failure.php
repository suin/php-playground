<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use BadMethodCallException;
use Exception;

/**
 * @template T
 * @extends Result<T>
 */
final class Failure extends Result
{
    /**
     * @var Exception
     */
    private $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * {@inheritdoc}
     */
    public function isFailure(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccess(): bool
    {
        return !$this->isFailure();
    }

    /**
     * {@inheritdoc}
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadMethodCallException
     */
    public function get(): void
    {
        throw new BadMethodCallException(
            'This method should not be called since there is no value in unsuccessful context'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $transform): Result
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function recover(callable $rescueException): Result
    {
        try {
            /** @psalm-suppress TooManyArguments */
            return self::success($rescueException($this->exception));
        } catch (Exception $exception) {
            return self::failure($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function recoverWith(callable $rescueException): Result
    {
        try {
            /** @psalm-suppress TooManyArguments */
            return $rescueException($this->exception);
        } catch (Exception $exception) {
            return self::failure($exception);
        }
    }
}
