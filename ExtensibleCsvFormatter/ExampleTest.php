<?php

/** @noinspection OneTimeUseVariablesInspection */

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use PHPUnit\Framework\TestCase;
use Suin\Playground\ExtensibleCsvFormatter\QuotationRule\Always;

final class ExampleTest extends TestCase
{
    /**
     * @test
     * @testdox Simple usage
     */
    public function example1(): void
    {
        // Initialize the formatter without options.
        // Default format is like below:
        // - delimiter is comma (,)
        // - enclosure is double quotation (")
        // - newline is LF (\n)
        $formatter = new CsvFormatter();

        // Give a record to the format method. To passing an array, you have to
        // use '...' operator. All of the elements of the record array must be
        // string, otherwise this method rises TypeError.
        $record = ['a', 'あ', '123', 'a,b', '"'];
        $csvString = $formatter->format(...$record);

        // Then the output would be like this:
        self::assertSame('a,あ,123,"a,b",""""' . "\n", $csvString);
    }

    /**
     * @test
     * @testdox Customize format
     */
    public function example2(): void
    {
        // Pass the CsvOption to the first argument of the constructor of the
        // CsvFormatter:
        $tsvFormatter = new CsvFormatter(
            (new CsvOption())
                ->delimiter("\t")
                ->enclosure("'")
                ->newlineCRLF()
        );

        $tsvString = $tsvFormatter->format('a', "\t", 'a,b');

        self::assertSame("a\t'\t'\ta,b\r\n", $tsvString);
    }

    /**
     * @test
     * @testdox Always quote fields
     */
    public function example3(): void
    {
        // To quote fields always, give Always rule to the second argument of
        // the constructor of CsvFormat:
        $alwaysQuotingFormatter = new CsvFormatter(null, new Always());

        $csvString = $alwaysQuotingFormatter->format('a', 'b', 'c');

        self::assertSame('"a","b","c"' . "\n", $csvString);
    }
}
