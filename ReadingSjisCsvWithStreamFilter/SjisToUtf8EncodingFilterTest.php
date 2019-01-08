<?php

declare(strict_types=1);

namespace Suin\Playground\ReadingSjisCsvWithStreamFilter;

use PHPUnit\Framework\TestCase;

final class SjisToUtf8EncodingFilterTest extends TestCase
{
    private const FILTER_NAME = 'sjis_to_utf8_encoding_filter';

    protected function setUp(): void
    {
        \stream_filter_register(
            self::FILTER_NAME,
            SjisToUtf8EncodingFilter::class
        );
    }

    /**
     * @test
     */
    public function encode_small_data(): void
    {
        $utf8Value = 'あ,い,う';
        $sjisValue = $this->getSjisValue($utf8Value);
        $resource = $this->createReadableResource($sjisValue);
        self::assertSame(['あ', 'い', 'う'], \fgetcsv($resource));
    }

    /**
     * @test
     */
    public function encode_big_data_that_exceeds_stream_chunk_size(): void
    {
        $utf8Value = 'かきくけこ,さしすせそ';
        $sjisValue = $this->getSjisValue($utf8Value);
        $resource = $this->createReadableResource($sjisValue);
        $this->changeStreamChunkSize($resource, 5);
        // SJIS string will be separated into 5 chunks like following:
        //  1 2 3 4 5   1 2 3 4 5   1 2 3 4 5   1 2 3 4 5   1 2 3 4 5
        // [k a k i k] [u k e k o] [, s a s i] [s u s e s] [o        ]
        self::assertSame(['かきくけこ', 'さしすせそ'], \fgetcsv($resource));
    }

    /**
     * @test
     */
    public function fgetcsv_doesnt_occur_5c_problem(): void
    {
        $utf8Value = '"表"';
        $sjisValue = $this->getSjisValue($utf8Value);
        self::assertSame(
            '22 95 5c 22 ',
            \chunk_split(\bin2hex($sjisValue), 2, ' ')
        );
        $resource = $this->createReadableResource($sjisValue);
        self::assertSame(['表'], \fgetcsv($resource));
    }

    private function getSjisValue(string $utf8Value): string
    {
        return \mb_convert_encoding($utf8Value, 'SJIS-win', 'UTF-8');
    }

    /**
     * @return resource
     */
    private function createReadableResource(string $content)
    {
        $fp = \tmpfile();
        \fwrite($fp, $content);
        \rewind($fp);
        /** @noinspection UnusedFunctionResultInspection */
        \stream_filter_append($fp, self::FILTER_NAME);
        return $fp;
    }

    /**
     * @param resource $resource
     */
    private function changeStreamChunkSize($resource, int $chunkSize): void
    {
        self::assertInternalType('resource', $resource);
        \stream_set_chunk_size($resource, $chunkSize);
        \stream_set_read_buffer($resource, $chunkSize);
    }
}
