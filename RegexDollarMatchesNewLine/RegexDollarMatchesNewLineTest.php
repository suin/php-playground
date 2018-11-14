<?php

declare(strict_types=1);

namespace Suin\Playground\RegexDollarMatchesNewLine;

use PHPUnit\Framework\TestCase;

class RegexDollarMatchesNewLineTest extends TestCase
{
    /**
     * @test
     */
    public function demo(): void
    {
        self::assertSame(\preg_match('/^hello$/', 'hello'), 1);
        self::assertSame(\preg_match('/^hello$/', "hello\n"), 1);
        self::assertSame(\preg_match('/\Ahello\z/', 'hello'), 1);
        self::assertSame(\preg_match('/\Ahello\z/', "hello\n"), 0);
    }
}
