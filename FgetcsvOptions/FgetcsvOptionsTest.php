<?php

declare(strict_types=1);

namespace Suin\Playground\FgetcsvOptions;

use PHPUnit\Framework\TestCase;
use SplFileObject;

final class FgetcsvOptionsTest extends TestCase
{
    private $filename;

    protected function setUp(): void
    {
        parent::setUp();
        $this->filename = \tempnam(\sys_get_temp_dir(), 'CSV');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \unlink($this->filename);
    }

    /**
     * @test
     * @testdox SplFileObject::SKIP_EMPTY does not skip empty line
     */
    public function skip_empty_line(): void
    {
        $this->createCsvData(
            'a,b',
            '', // empty line
            'c,d',
            '' // empty line
        );
        $file = new SplFileObject($this->filename, 'r');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        self::assertSame(
            [['a', 'b'], [null], ['c', 'd'], false],
            \iterator_to_array($file, false)
        );
    }

    /**
     * @test
     * @testdox SplFileObject::SKIP_EMPTY & SplFileObject::READ_AHEAD drops the
     *     end of file newline
     */
    public function skip_drop_new_line_and_read_ahead(): void
    {
        $this->createCsvData(
            'a,b',
            '', // empty line
            'c,d',
            '' // empty line
        );
        $file = new SplFileObject($this->filename, 'r');
        $file->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::READ_AHEAD
        );
        self::assertSame(
            [['a', 'b'], [null], ['c', 'd']],
            \iterator_to_array($file, false)
        );
    }

    /**
     * @test
     * @testdox SplFileObject::SKIP_EMPTY & SplFileObject::READ_AHEAD &
     *     SplFileObject::DROP_NEW_LINE drops all empty lines
     */
    public function skip_drop_new_line_and_read_ahead_and_drop_new_line(): void
    {
        $this->createCsvData(
            'a,b',
            '', // empty line
            '', // empty line
            'c,d',
            '' // empty line
        );
        $file = new SplFileObject($this->filename, 'r');
        $file->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::READ_AHEAD
            | SplFileObject::DROP_NEW_LINE
        );
        self::assertSame(
            [['a', 'b'], ['c', 'd']],
            \iterator_to_array($file, false)
        );
    }

    /**
     * @test
     */
    public function drop_new_line_and_new_line_in_a_cell(): void
    {
        $this->createCsvData(
            "\"a\nb\"",
            "\"\nc\nd\"",
            "\"e\nf\ng\"",
            "\"h\ni\nj\nk\n\""
        );
        $file = new SplFileObject($this->filename, 'r');
        $file->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::READ_AHEAD
            | SplFileObject::DROP_NEW_LINE
        );
        self::assertSame(
            [['ab'], ["c\nd"], ["ef\ng"], ["hi\nj\nk\n"]],
            \iterator_to_array($file, false)
        );
    }

    /**
     * @test
     * @testdox $escape provides alternative way to escape $enclosure.
     * This only treats alternative escaping way is valid syntax.
     * This does NOT remove $escape character from value.
     */
    public function escape(): void
    {
        $this->createCsvData(
            '"a""b"', // escape enclosure with doubled-enclosure
            'c\\"d' // escape enclosure with escape character
        );
        $file = new SplFileObject($this->filename, 'r');
        $file->setFlags(SplFileObject::READ_CSV);
        $file->setCsvControl(',', '"', '\\');
        self::assertSame(
            [['a"b'], ['c\\"d']],
            \iterator_to_array($file, false)
        );
    }

    private function createCsvData(string ...$rows): void
    {
        \file_put_contents($this->filename, \implode("\n", $rows));
    }
}
