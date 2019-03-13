<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use IteratorAggregate;
use Traversable;

final class CsvFormatPatterns implements IteratorAggregate
{
    /**
     * @var CsvFormatPattern[]
     */
    private $patterns = [];

    public function record(string ...$record): self
    {
        $this->patterns[] = (new CsvFormatPattern())->record(...$record);
        return $this;
    }

    public function format(string $format): self
    {
        $this->previousPattern()->expectedFormat($format);
        return $this;
    }

    public function newline(string $newline): self
    {
        $this->previousPattern()->newline($newline);
        return $this;
    }

    public function delimiter(string $delimiter): self
    {
        $this->previousPattern()->delimiter($delimiter);
        return $this;
    }

    public function getIterator(): Traversable
    {
        foreach ($this->patterns as $index => $pattern) {
            yield "#{$index} {$pattern->describe()}" => $pattern->toArray();
        }
    }

    private function previousPattern(): CsvFormatPattern
    {
        return \array_slice($this->patterns, -1)[0];
    }
}
