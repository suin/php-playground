<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use BadMethodCallException;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class FailureTest extends TestCase
{
    public function test_is_failure(): void
    {
        self::assertTrue(self::newFailure()->isFailure());
    }

    public function test_is_success(): void
    {
        self::assertFalse(self::newFailure()->isSuccess());
    }

    public function test_get_exception(): void
    {
        $exception = self::dummyException();
        $failure = new Failure($exception);
        self::assertSame($exception, $failure->getException());
    }

    public function test_get(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage(
            'This method should not be called since there is no value in unsuccessful context'
        );
        self::newFailure()->get();
    }

    public function test_map(): void
    {
        $failure = self::newFailure();
        $failure2 = $failure->map(self::dummyTransform());
        self::assertSame($failure, $failure2);
    }

    public function test_recover(): void
    {
        $success = self::newFailure()
            ->recover(
                function (): int {
                    return 100;
                }
            );
        self::assertSame(100, $success->get());
    }

    public function test_recover_depends_on_exception_type(): void
    {
        $recoverableException = new RuntimeException('something wrong');
        $unrecoverableException = new LogicException('wrong');

        $rescueException = function (Exception $exception): int {
            return $exception instanceof RuntimeException ? 999 : 0;
        };

        $success = (new Failure($recoverableException))
            ->recover($rescueException);
        self::assertSame(999, $success->get());

        $success = (new Failure($unrecoverableException))
            ->recover($rescueException);
        self::assertSame(0, $success->get());
    }

    public function test_catches_exception_during_recovering(): void
    {
        $failure = self::newFailure()
            ->recover(
                function (): int {
                    throw new RuntimeException('Error during recovering!');
                }
            );
        self::assertSame(
            'Error during recovering!',
            $failure->getException()->getMessage()
        );
    }

    public function test_recover_with(): void
    {
        $result = self::newFailure()
            ->recoverWith(
                function (): Result {
                    return Result::success(100);
                }
            );
        self::assertSame(100, $result->get());
    }

    public function test_recover_with_depends_on_exception_type(): void
    {
        $recoverableException = new RuntimeException('something wrong');
        $unrecoverableException = new LogicException('wrong');

        $rescueException = function (Exception $exception): Result {
            return $exception instanceof RuntimeException
                ? Result::success(999)
                : Result::failure(
                    new RuntimeException('Unrecoverable!', 0, $exception)
                );
        };

        $success = (new Failure($recoverableException))
            ->recoverWith($rescueException);
        self::assertSame(999, $success->get());

        $failure = (new Failure($unrecoverableException))
            ->recoverWith($rescueException);
        self::assertSame(
            'Unrecoverable!',
            $failure->getException()->getMessage()
        );
        self::assertSame(
            $unrecoverableException,
            $failure->getException()->getPrevious()
        );
    }

    public function test_catches_exception_during_recovering_with(): void
    {
        $failure = self::newFailure()
            ->recoverWith(
                /**
                 * @return Result<int>
                 */
                function (): Result {
                    throw new RuntimeException('Error during recovering!');
                }
            );
        self::assertSame(
            'Error during recovering!',
            $failure->getException()->getMessage()
        );
    }

    /**
     * @return Failure<int>
     * @psalm-suppress MixedTypeCoercion
     */
    private static function newFailure(): Failure
    {
        return new Failure(self::dummyException());
    }

    private static function dummyException(): Exception
    {
        return new Exception('dummy exception');
    }

    private static function dummyTransform(): callable
    {
        return function (int $v): int {
            return $v;
        };
    }
}
