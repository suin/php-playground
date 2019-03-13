<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

final class CsvOption
{
    private const CR = "\r";

    private const LF = "\n";

    private const CRLF = "\r\n";

    /**
     * @var string
     */
    private $delimiter = ',';

    /**
     * @var string
     */
    private $enclosure = '"';

    /**
     * @var string
     */
    private $newline = self::LF;

    public function delimiter(string $delimiter): self
    {
        self::assertDelimiter($delimiter, $this->enclosure);
        $new = clone $this;
        $new->delimiter = $delimiter;
        return $new;
    }

    public function enclosure(string $enclosure): self
    {
        self::assertDelimiter($this->delimiter, $enclosure);
        self::assertEnclosure($enclosure);
        $new = clone $this;
        $new->enclosure = $enclosure;
        return $new;
    }

    public function newlineCRLF(): self
    {
        return $this->newline(self::CRLF);
    }

    public function newlineLF(): self
    {
        return $this->newline(self::LF);
    }

    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    public function getNewline(): string
    {
        return $this->newline;
    }

    private function newline(string $newline): self
    {
        \assert(\in_array($newline, [self::LF, self::CRLF], true));
        $new = clone $this;
        $new->newline = $newline;
        return $new;
    }

    private static function assertDelimiter(
        string $delimiter,
        string $enclosure
    ): void {
        self::assertDelimiterIsSingleByteCharacter($delimiter);
        self::assertDelimiterIsAllowedCharacter($delimiter);
        self::assertDelimiterAndEnclosureIsDifferent($delimiter, $enclosure);
    }

    private static function assertEnclosure(string $enclosure): void
    {
        self::assertEnclosureIsSingleByteCharacter($enclosure);
        self::assertEnclosureIsAllowedCharacter($enclosure);
    }

    private static function assertDelimiterIsSingleByteCharacter(
        string $delimiter
    ): void {
        if (\strlen($delimiter) !== 1) {
            throw CsvOptionError::delimiterIsNotSingleByteCharacter($delimiter);
        }
    }

    private static function assertDelimiterIsAllowedCharacter(
        string $delimiter
    ): void {
        $invalidDelimiters = ["\0", self::CR, self::LF];

        if (\in_array($delimiter, $invalidDelimiters, true)) {
            throw CsvOptionError::notAllowedDelimiter(
                $delimiter,
                $invalidDelimiters
            );
        }
    }

    private static function assertDelimiterAndEnclosureIsDifferent(
        string $delimiter,
        string $enclosure
    ): void {
        if ($delimiter === $enclosure) {
            throw CsvOptionError::delimiterSameAsEnclosure(
                $delimiter,
                $enclosure
            );
        }
    }

    private static function assertEnclosureIsSingleByteCharacter(
        string $enclosure
    ): void {
        if (\strlen($enclosure) !== 1) {
            throw CsvOptionError::enclosureIsNotSingleByteCharacter($enclosure);
        }
    }

    private static function assertEnclosureIsAllowedCharacter(
        string $enclosure
    ): void {
        $invalidEnclosures = ["\0", self::CR, self::LF];

        if (\in_array($enclosure, $invalidEnclosures, true)) {
            throw CsvOptionError::notAllowedEnclosure(
                $enclosure,
                $invalidEnclosures
            );
        }
    }
}
