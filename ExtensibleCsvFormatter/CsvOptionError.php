<?php

declare(strict_types=1);

namespace Suin\Playground\ExtensibleCsvFormatter;

use LogicException;

final class CsvOptionError
{
    public static function delimiterIsNotSingleByteCharacter(
        string $invalidDelimiter
    ): LogicException {
        return new LogicException(
            \sprintf(
                'Delimiter must be a single byte character, but %s is given',
                self::describeString($invalidDelimiter)
            )
        );
    }

    /**
     * @param string[] $notAllowedCharacters
     */
    public static function notAllowedDelimiter(
        string $invalidDelimiter,
        array $notAllowedCharacters
    ): LogicException {
        return new LogicException(
            \sprintf(
                'Delimiter must not be one of [%s], but given %s',
                self::describeCharacters($notAllowedCharacters),
                self::describeCharacter($invalidDelimiter)
            )
        );
    }

    public static function delimiterSameAsEnclosure(
        string $delimiter,
        string $enclosure
    ): LogicException {
        return new LogicException(
            \sprintf(
                'Delimiter %s must be different from the enclosure %s',
                self::describeCharacter($delimiter),
                self::describeCharacter($enclosure)
            )
        );
    }

    public static function enclosureIsNotSingleByteCharacter(
        string $invalidEnclosure
    ): LogicException {
        return new LogicException(
            \sprintf(
                'Enclosure must be a single byte character, but %s is given',
                self::describeString($invalidEnclosure)
            )
        );
    }

    /**
     * @param string[] $notAllowedCharacters
     */
    public static function notAllowedEnclosure(
        string $invalidEnclosure,
        array $notAllowedCharacters
    ): LogicException {
        return new LogicException(
            \sprintf(
                'Enclosure must not be one of [%s], but given %s',
                self::describeCharacters($notAllowedCharacters),
                self::describeCharacter($invalidEnclosure)
            )
        );
    }

    private static function describeString(string $string): string
    {
        $characters = \preg_split('//u', $string, -1, \PREG_SPLIT_NO_EMPTY);

        if (\count($characters) === 0) {
            return 'empty-string';
        }

        $describedCharacters = [];
        $codePoints = [];

        foreach ($characters as $char) {
            $describedCharacters[] = self::visualizeInvisibleCharacter($char);
            $codePoints[] = self::getCodePoint($char);
        }

        return \sprintf(
            "'%s'(%s)",
            \implode('', $describedCharacters),
            \implode(' ', $codePoints)
        );
    }

    /**
     * @param string[] $characters
     */
    private static function describeCharacters(
        array $characters,
        ?string $separator = null
    ): string {
        $describedChars = [];

        foreach ($characters as $character) {
            $describedChars[] = self::describeCharacter($character);
        }

        return \implode($separator ?? ', ', $describedChars);
    }

    private static function describeCharacter(string $char): string
    {
        return \sprintf(
            "'%s'(%s)",
            self::visualizeInvisibleCharacter($char),
            self::getCodePoint($char)
        );
    }

    private static function visualizeInvisibleCharacter(string $char): string
    {
        return \addcslashes($char, "\0\r\n\t\v\f");
    }

    private static function getCodePoint(string $char): string
    {
        return \sprintf(
            'U+%04X',
            \hexdec(\bin2hex(\mb_convert_encoding($char, 'UCS-4', 'UTF-8')))
        );
    }
}
