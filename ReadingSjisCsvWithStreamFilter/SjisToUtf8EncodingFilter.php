<?php

declare(strict_types=1);

namespace Suin\Playground\ReadingSjisCsvWithStreamFilter;

final class SjisToUtf8EncodingFilter extends \php_user_filter
{
    /**
     * Buffer size limit (bytes)
     *
     * @var int
     */
    private static $bufferSizeLimit = 1024;

    /**
     * @var string
     */
    private $buffer = '';

    public static function setBufferSizeLimit(int $bufferSizeLimit): void
    {
        self::$bufferSizeLimit = $bufferSizeLimit;
    }

    /**
     * @param resource $in
     * @param resource $out
     * @param int $consumed
     * @param bool $closing
     */
    public function filter($in, $out, &$consumed, $closing): int
    {
        $isBucketAppended = false;
        $previousData = $this->buffer;
        $deferredData = '';

        while ($bucket = \stream_bucket_make_writeable($in)) {
            $data = $previousData . $bucket->data;
            $consumed += $bucket->datalen;

            while ($this->needsToNarrowEncodingDataScope($data)) {
                $deferredData = \substr($data, -1) . $deferredData;
                $data = \substr($data, 0, -1);
            }

            if ($data) {
                $bucket->data = $this->encode($data);
                \stream_bucket_append($out, $bucket);
                $isBucketAppended = true;
            }
        }

        $this->buffer = $deferredData;
        $this->assertBufferSizeIsSmallEnough();
        return $isBucketAppended ? \PSFS_PASS_ON : \PSFS_FEED_ME;
    }

    private function needsToNarrowEncodingDataScope(string $string): bool
    {
        return !($string === '' || $this->isValidEncoding($string));
    }

    private function isValidEncoding(string $string): bool
    {
        return \mb_check_encoding($string, 'SJIS-win');
    }

    private function encode(string $string): string
    {
        return \mb_convert_encoding($string, 'UTF-8', 'SJIS-win');
    }

    private function assertBufferSizeIsSmallEnough(): void
    {
        \assert(
            \strlen($this->buffer) <= self::$bufferSizeLimit,
            \sprintf(
                'Streaming buffer size must less than or equal to %u bytes, but %u bytes allocated',
                self::$bufferSizeLimit,
                \strlen($this->buffer)
            )
        );
    }
}
