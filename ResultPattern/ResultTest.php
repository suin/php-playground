<?php

declare(strict_types=1);

namespace Suin\Playground\ResultPattern;

use PHPUnit\Framework\TestCase;
use RuntimeException;

final class ResultTest extends TestCase
{
    /**
     * @test
     */
    public function example(): void
    {
        /**
         * @psalm-var callable(float, float): Result<float> $div
         */
        $div = function (float $x, float $y): Result {
            return $y === 0.0
                ? Result::failure(new RuntimeException('Division by zero'))
                : Result::success($x / $y);
        };

        $result = $div(8, 2);

        if ($result->isFailure()) {
            // エラーハンドリングはisFailure()もしくはisSuccess()で結果状態を判定した上で、
            // getException()で例外オブジェクトを参照する。
            $exception = $result->getException();
            self::assertSame('Division by zero', $exception->getMessage());
        } else {
            // 正常系はisFailure()もしくはisSuccess()で結果状態を判定した上で、
            // get()で結果の値を取得する。
            $value = $result->get();
            self::assertSame(4.0, $value);
        }
    }

    /**
     * @test
     */
    public function create_success(): void
    {
        $success = Result::success('OK');
        $this->expect($success)
            ->toBeSuccess()
            ->valueToBe('OK');
    }

    /**
     * @test
     */
    public function create_failure(): void
    {
        $failure = Result::failure(new RuntimeException('wrong'));
        $this->expect($failure)
            ->toBeFailure()
            ->exceptionTypeToBe(RuntimeException::class)
            ->exceptionMessageToBe('wrong');
    }

    /**
     * @template T
     * @psalm-param Result<T> $result
     * @psalm-return ResultExpect<T>
     */
    private function expect(Result $result): ResultExpect
    {
        return new ResultExpect($result);
    }
}
