<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use LogicException;
use PHPUnit\Framework\TestCase;

final class CsvOptionTest extends TestCase
{
    /**
     * @dataProvider validDelimiters
     */
    public function test_valid_delimiter(
        ?string $validDelimiter,
        string $expectedDelimiter
    ): void {
        $option = new CsvOption();

        if ($validDelimiter !== null) {
            $option = $option->delimiter($validDelimiter);
        }
        self::assertSame($expectedDelimiter, $option->getDelimiter());
    }

    public function validDelimiters(): iterable
    {
        return [
            'default' => [null, ','],
            'comma' => [',', ','],
            'tab' => ["\t", "\t"],
            'pipe' => ['|', '|'],
            'colon' => [':', ':'],
        ];
    }

    /**
     * @dataProvider invalidDelimiters
     */
    public function test_invalid_delimiter(
        string $invalidDelimiter,
        string $exceptionMessage
    ): void {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($exceptionMessage);
        (new CsvOption())->delimiter($invalidDelimiter);
    }

    public function invalidDelimiters(): iterable
    {
        return [
            'empty string' => [
                '',
                'Delimiter must be a single byte character, but empty-string is given',
            ],
            'two characters' => [
                ',,',
                "Delimiter must be a single byte character, but ',,'(U+002C U+002C) is given",
            ],
            'three characters' => [
                ':::',
                "Delimiter must be a single byte character, but ':::'(U+003A U+003A U+003A) is given",
            ],
            'multi-byte character' => [
                'あ',
                "Delimiter must be a single byte character, but 'あ'(U+3042) is given",
            ],
            'CR' => [
                "\r",
                'Delimiter must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\r\'(U+000D)',
            ],
            'LF' => [
                "\n",
                'Delimiter must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\n\'(U+000A)',
            ],
            'null byte' => [
                "\0",
                'Delimiter must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\000\'(U+0000)',
            ],
        ];
    }

    /**
     * @dataProvider conflictPairsOfDelimiterAndEnclosure
     */
    public function test_delimiter_and_enclosure_is_same(
        ?string $validDelimiter,
        ?string $validEnclosure,
        string $exceptionMessage
    ): void {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $option = new CsvOption();

        if ($validDelimiter !== null) {
            $option = $option->delimiter($validDelimiter);
        }

        if ($validEnclosure !== null) {
            $option = $option->enclosure($validEnclosure);
        }
    }

    public function conflictPairsOfDelimiterAndEnclosure(): iterable
    {
        return [
            'delimiter is double-quote, enclosure is default' => [
                '"',
                null,
                "Delimiter '\"'(U+0022) must be different from the enclosure '\"'(U+0022)",
            ],
            'delimiter is double-quote, enclosure is double-quote' => [
                '"',
                '"',
                "Delimiter '\"'(U+0022) must be different from the enclosure '\"'(U+0022)",
            ],
            'delimiter is default, enclosure is comma' => [
                null,
                ',',
                "Delimiter ','(U+002C) must be different from the enclosure ','(U+002C)",
            ],
            'delimiter is comma, enclosure is comma' => [
                ',',
                ',',
                "Delimiter ','(U+002C) must be different from the enclosure ','(U+002C)",
            ],
            'delimiter is tab, enclosure is tab' => [
                "\t",
                "\t",
                'Delimiter \'\t\'(U+0009) must be different from the enclosure \'\t\'(U+0009)',
            ],
        ];
    }

    /**
     * @dataProvider validEnclosures
     */
    public function test_valid_enclosure(
        ?string $validEnclosure,
        string $expectedEnclosure
    ): void {
        $option = new CsvOption();

        if ($validEnclosure !== null) {
            $option = $option->enclosure($validEnclosure);
        }
        self::assertSame($expectedEnclosure, $option->getEnclosure());
    }

    public function validEnclosures(): iterable
    {
        return [
            'default' => [null, '"'],
            'double-quote' => ['"', '"'],
            'single-quote' => ["'", "'"],
            '@' => ['@', '@'],
            '#' => ['#', '#'],
        ];
    }

    /**
     * @dataProvider invalidEnclosures
     */
    public function test_invalid_enclosure(
        string $invalidEnclosure,
        string $exceptionMessage
    ): void {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($exceptionMessage);
        (new CsvOption())->enclosure($invalidEnclosure);
    }

    public function invalidEnclosures(): iterable
    {
        return [
            'empty string' => [
                '',
                'Enclosure must be a single byte character, but empty-string is given',
            ],
            'two characters' => [
                '""',
                "Enclosure must be a single byte character, but '\"\"'(U+0022 U+0022) is given",
            ],
            'three characters' => [
                '"""',
                "Enclosure must be a single byte character, but '\"\"\"'(U+0022 U+0022 U+0022) is given",
            ],
            'multi-byte character' => [
                'あ',
                "Enclosure must be a single byte character, but 'あ'(U+3042) is given",
            ],
            'CR' => [
                "\r",
                'Enclosure must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\r\'(U+000D)',
            ],
            'LF' => [
                "\n",
                'Enclosure must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\n\'(U+000A)',
            ],
            'null byte' => [
                "\0",
                'Enclosure must not be one of [\'\000\'(U+0000), \'\r\'(U+000D), \'\n\'(U+000A)], but given \'\000\'(U+0000)',
            ],
        ];
    }

    public function test_valid_newline(): void
    {
        self::assertSame("\n", (new CsvOption())->getNewline());
        self::assertSame(
            "\r\n",
            (new CsvOption())->newlineCRLF()->getNewline()
        );
        self::assertSame(
            "\n",
            (new CsvOption())->newlineLF()->getNewline()
        );
    }
}
