<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

final class CsvFormatPattern
{
    /**
     * @var null|string[]
     */
    private $record;

    /**
     * @var null|string
     */
    private $expectedFormat;

    /**
     * @var null|string
     */
    private $newline;

    /**
     * @var null|string
     */
    private $delimiter;

    public function record(string ...$record): self
    {
        $this->record = $record;
        return $this;
    }

    public function expectedFormat(string $format): self
    {
        $this->expectedFormat = $format;
        return $this;
    }

    public function newline(string $newline): self
    {
        $this->newline = $newline;
        return $this;
    }

    public function delimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    public function toArray(): array
    {
        return [$this->record, $this->expectedFormat, $this->csvOption()];
    }

    public function describe(): string
    {
        return \implode(
            ', ',
            \array_filter(
                [
                    $this->describeRecord(),
                    $this->describeExpectedFormat(),
                    $this->describeNewline(),
                    $this->describeDelimiter(),
                ]
            )
        );
    }

    private function describeRecord(): string
    {
        \assert(\is_array($this->record));
        $record = \implode(
            ', ',
            \array_map([$this, 'describeString'], $this->record)
        );
        return "record: [{$record}]";
    }

    private function describeExpectedFormat(): string
    {
        \assert(\is_string($this->expectedFormat));
        return "format: [{$this->describeString($this->expectedFormat)}]";
    }

    private function describeNewline(): string
    {
        return $this->newline
            ? "newline: {$this->describeString($this->newline)}"
            : '';
    }

    private function describeDelimiter(): string
    {
        return $this->delimiter
            ? "delimiter: {$this->describeString($this->delimiter)}"
            : '';
    }

    private function describeString(string $string): string
    {
        return \addcslashes($string, "\0\n\r\v\t\f");
    }

    private function csvOption(): CsvOption
    {
        $csvOption = new CsvOption();

        if ($this->delimiter !== null) {
            $csvOption = $csvOption->delimiter($this->delimiter);
        }

        if ($this->newline === "\r\n") {
            $csvOption = $csvOption->newlineCRLF();
        }

        return $csvOption;
    }
}
