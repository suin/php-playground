<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use PHPUnit\Framework\TestCase;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule\Always;

final class CsvFormatterTest extends TestCase
{
    /**
     * @dataProvider formatPatterns
     *
     * @param string[] $record
     */
    public function test_format(
        array $record,
        string $expected,
        ?CsvOption $option = null
    ): void {
        $formatter = new CsvFormatter($option);
        self::assertSame($expected, $formatter->format(...$record));
    }

    public function formatPatterns(): iterable
    {
        return (new CsvFormatPatterns())
            ->record()->format("\n")
            ->record('abc')->format("abc\n")
            ->record('abc')->format("abc\r\n")->newline("\r\n")
            ->record('"abc"')->format('"""abc"""' . "\n")
            ->record('a"b')->format('"a""b"' . "\n")
            ->record('"a"b"')->format('"""a""b"""' . "\n")
            ->record(' abc')->format('" abc"' . "\n")
            ->record('abc ')->format('"abc "' . "\n")
            ->record('a bc')->format('"a bc"' . "\n")
            ->record('abc,def')->format('"abc,def"' . "\n")
            ->record('abc', 'def')->format("abc,def\n")
            ->record("abc\ndef")->format("\"abc\ndef\"\n")
            ->record("abc\ndef")->format("\"abc\ndef\"\r\n")->newline("\r\n")
            ->record("abc\rdef")->format("\"abc\rdef\"\r\n")->newline("\r\n")
            ->record("abc\r\ndef")->format("\"abc\r\ndef\"\n")
            ->record("abc\rdef")->format("\"abc\rdef\"\n")
            ->record('')->format("\n")
            ->record('', '')->format(",\n")
            ->record('', '', '')->format(",,\n")
            ->record('', '', 'a')->format(",,a\n")
            ->record('', 'a', '')->format(",a,\n")
            ->record('', 'a', 'a')->format(",a,a\n")
            ->record('a', '', '')->format("a,,\n")
            ->record('a', '', 'a')->format("a,,a\n")
            ->record('a', 'a', '')->format("a,a,\n")
            ->record('a', 'a', 'a')->format("a,a,a\n")
            ->record("\f", "\t", "\v")->format("\"\f\",\"\t\",\"\v\"\n")
            ->record(',')->format('","' . "\n")
            ->record(',')->format(',' . "\n")->delimiter("\t")
            ->record(',', "\t")->format(",\t\"\t\"\n")->delimiter("\t")
            // https://bugs.php.net/bug.php?id=43225
            ->record('a\\"', 'bbb')->format('"a\""",bbb' . "\n")
            // https://bugs.php.net/bug.php?id=74713
            ->record('"@@","B"')->format('"""@@"",""B"""' . "\n")
            // https://bugs.php.net/bug.php?id=55413
            ->record('A', 'Some "Stuff"', 'C')->format(
                'A,"Some ""Stuff""",C' . "\n"
            )
            // https://github.com/thephpleague/csv/issues/307
            ->record('a text string \\', '...')->format(
                '"a text string \\",...' . "\n"
            );
    }

    /**
     * @dataProvider quoteAlwaysPatterns
     *
     * @param string[] $record
     */
    public function test_quote_always(
        array $record,
        string $expected,
        ?CsvOption $option = null
    ): void {
        $formatter = new CsvFormatter($option, new Always());
        self::assertSame($expected, $formatter->format(...$record));
    }

    public function quoteAlwaysPatterns(): iterable
    {
        return (new CsvFormatPatterns())
            ->record('abc')->format('"abc"' . "\n")
            ->record('abc')->format('"abc"' . "\r\n")->newline("\r\n")
            ->record('abc', 'def')->format('"abc","def"' . "\n")
            ->record('')->format('""' . "\n")
            ->record('', '')->format('"",""' . "\n")
            ->record('', '', '')->format('"","",""' . "\n");
    }
}
