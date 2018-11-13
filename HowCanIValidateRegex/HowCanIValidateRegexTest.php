<?php

declare(strict_types=1);

namespace Suin\Playground\HowCanIValidateRegex;

use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

class HowCanIValidateRegexTest extends TestCase
{
    protected function setUp(): void
    {
        \error_clear_last();
    }

    /**
     * 正規表現が正しくないとき、PHPはWarningを出します。
     *
     * @test
     */
    public function php_reports_warning_if_regular_expression_is_invalid(): void
    {
        $this->expectException(Warning::class);
        $this->expectExceptionMessage(
            'preg_match(): Compilation failed: nothing to repeat at offset 0'
        );
        \preg_match('/*invalid-regular-expression/', '');
    }

    /**
     * そのWarningは@オペレータを出さないようにできます。
     * そのときの戻り値はfalseになります。
     *
     * @test
     */
    public function the_warning_can_be_suppressed(): void
    {
        $result = @\preg_match('/*invalid-regular-expression/', '');
        self::assertFalse($result);
    }

    /**
     * 抑制したWarningはerror_get_last関数で取ることができます。
     *
     * @test
     */
    public function you_can_get_the_suppressed_warning_by_error_get_last(): void
    {
        @\preg_match('/*invalid-regular-expression/', '');
        self::assertSame(
            [
                'type' => \E_WARNING,
                'message' => 'preg_match(): Compilation failed: nothing to repeat at offset 0',
                'file' => __FILE__,
                'line' => __LINE__ - 6,
            ],
            \error_get_last()
        );
    }

    /**
     * 正規表現のエラーを取得する関数にpreg_last_errorもありますが、
     * error_get_lastに比べるとずっと情報量が少ないです。
     *
     * @test
     */
    public function preg_last_error_provides_less_information(): void
    {
        @\preg_match('/*invalid-regular-expression/', '');
        self::assertSame(\PREG_INTERNAL_ERROR, \preg_last_error());
    }

    /**
     * エラーハンドラが登録されているときは、error_get_lastでエラーを取る方法はうまくいきません。
     *
     * @test
     */
    public function error_get_last_does_not_work_well_if_handler_exists(): void
    {
        $hasErrorHandlerInvoked = false;
        // if error handler exists,
        \set_error_handler(
            function () use (&$hasErrorHandlerInvoked): void {
                \restore_error_handler();
                $hasErrorHandlerInvoked = true;
            }
        );
        // error_get_last can't get the warning.
        @\preg_match('/*invalid-regular-expression/', '');
        self::assertTrue($hasErrorHandlerInvoked);
        self::assertNull(\error_get_last());
    }

    /**
     * error_reportingを無効化してもerror_handlerがセットされているとうまくいかない。
     *
     * @test
     */
    public function even_if_disable_error_reporting_error_handler_works(): void
    {
        $hasErrorHandlerInvoked = false;
        \set_error_handler(
            function () use (&$hasErrorHandlerInvoked): void {
                $hasErrorHandlerInvoked = true;
            }
        );
        $errorReporting = \ini_get('error_reporting');
        \ini_set('error_reporting', 'Off');
        $result = @\preg_match('/*invalid-regular-expression/', '');
        self::assertFalse($result);
        self::assertTrue($hasErrorHandlerInvoked);
        \ini_set('error_reporting', $errorReporting);
    }

    /**
     * Warningの中身を取るには、一時的なエラーハンドラーをセットする方法がある
     *
     * @test
     */
    public function set_temporary_error_handler_to_get_warning(): void
    {
        // see https://qiita.com/mpyw/items/470f5f660080835f55a0
        $isValidRegex = function (string $regex): void {
            \set_error_handler(
                function ($severity, $message): void {
                    throw new \RuntimeException($message);
                }
            );

            try {
                \preg_match($regex, '');
            } finally {
                \restore_error_handler();
            }
        };
        // this is ok
        $isValidRegex('/a/');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'preg_match(): Compilation failed: nothing to repeat at offset 0'
        );
        $isValidRegex('/*a/');
    }
}
