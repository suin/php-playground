<?php

declare(strict_types=1);

namespace Suin\Playground\ReadingSjisCsvWithStreamFilter;

final class SjisToUtf8EncodingFilter extends \php_user_filter
{
    /**
     * @var string
     */
    private $buffer = '';

    /**
     * @param resource $in
     * @param resource $out
     * @param int $consumed
     * @param bool $closing
     */
    public function filter($in, $out, &$consumed, $closing): int
    {
        while ($bucket = \stream_bucket_make_writeable($in)) {
            $fullData = $this->buffer . $bucket->data;
            $consumed += $bucket->datalen;

            if ($this->isValidEncoding($fullData)) {
                $bucket->data = $this->encode($fullData);
                $this->clearBuffer();
                \stream_bucket_append($out, $bucket);
            } else {
                $this->buffer = $fullData;
                return \PSFS_FEED_ME;
            }
        }
        return \PSFS_PASS_ON;
    }

    private function isValidEncoding(string $string): bool
    {
        return \mb_check_encoding($string, 'SJIS-win');
    }

    private function encode(string $string): string
    {
        return \mb_convert_encoding($string, 'UTF-8', 'SJIS-win');
    }

    private function clearBuffer(): void
    {
        $this->buffer = '';
    }
}
