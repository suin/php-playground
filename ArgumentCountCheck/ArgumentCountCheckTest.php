<?php

declare(strict_types=1);

namespace Suin\Playground\ArgumentCountCheck;

use PHPUnit\Framework\TestCase;

final class ArgumentCountCheckTest extends TestCase
{
    public function dyadicFunction($arg1, $arg2): void
    {
        // do nothing
    }

    /**
     * @test
     * @testdox PHP throws ArgumentCountError if too few arguments are passed
     */
    public function pass_one_argument_to_dyadic_function(): void
    {
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessageRegExp('/Too few arguments/');
        /** @noinspection PhpParamsInspection */
        $this->dyadicFunction(1);
    }

    /**
     * @test
     * @testdox PHP doesn't throw any Exception if too much arguments are passed
     */
    public function pass_three_arguments_to_dyadic_function(): void
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $this->dyadicFunction(1, 2, 3);
        self::assertTrue(
            true,
            'This method call should not throw any exceptions'
        );
    }
}
