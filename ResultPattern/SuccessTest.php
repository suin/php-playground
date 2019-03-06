<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class SuccessTest extends TestCase
{
    public function test_is_failure(): void
    {
        self::assertFalse(self::newSuccess()->isFailure());
    }

    public function test_is_success(): void
    {
        self::assertTrue(self::newSuccess()->isSuccess());
    }

    public function test_get_exception(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage(
            'This method should not be called since there is no exception in successful context'
        );
        self::newSuccess()->getException();
    }

    public function test_get(): void
    {
        $success = new Success(100);
        self::assertSame(100, $success->get());
    }

    public function test_map(): void
    {
        /** @var Success<int> $success1 */
        $success1 = new Success(100);
        /** @var Success<int> $success2 */
        $success2 = $success1->map(
            function (int $num): int {
                return $num * 2;
            }
        );
        self::assertSame(200, $success2->get() * 1);
    }

    public function test_map_convert_exception_to_failure(): void
    {
        $failure = self::newSuccess()->map(
            function (
                /** @noinspection PhpUnusedParameterInspection */
                int $num
            ): int {
                throw new RuntimeException('Something wrong');
            }
        );
        self::assertSame(
            'Something wrong',
            $failure->getException()->getMessage()
        );
    }

    public function test_recover(): void
    {
        $success1 = self::newSuccess();
        $success2 = $success1->recover(
            function (): int {
                return 0;
            }
        );
        self::assertSame($success1, $success2);
    }

    public function test_recover_with(): void
    {
        $success1 = self::newSuccess();
        $success2 = $success1->recoverWith(
            function (): Result {
                return new Success(0);
            }
        );
        self::assertSame($success1, $success2);
    }

    /**
     * @psalm-return Success<int>
     */
    private static function newSuccess(): Success
    {
        return new Success(0);
    }
}
