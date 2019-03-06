<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use BadMethodCallException;
use Exception;

/**
 * @template T
 * @extends Result<T>
 */
final class Success extends Result
{
    /**
     * @psalm-var T
     *
     * @var mixed
     */
    private $value;

    /**
     * @psalm-param T $value
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isFailure(): bool
    {
        return false;
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
     *
     * @throws BadMethodCallException
     */
    public function getException(): Exception
    {
        throw new BadMethodCallException(
            'This method should not be called since there is no exception in successful context'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $transform): Result
    {
        try {
            return self::success($transform($this->value));
        } catch (Exception $exception) {
            return self::failure($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function recover(callable $rescueException): Result
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function recoverWith(callable $rescueException): Result
    {
        return $this;
    }
}
