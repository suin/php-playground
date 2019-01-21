<?php

declare(strict_types=1);

namespace Suin\Playground\CreateFileWithGivenSize;

final class FileBySizeCreator
{
    /**
     * Create a file with given megabyte size.
     */
    public function createFileWithMegabyte(
        string $filename,
        int $megabyte
    ): void {
        $fp = \fopen($filename, 'wb');
        \fseek($fp, $this->megabyteToByte($megabyte) - 1, \SEEK_CUR);
        \fwrite($fp, "\0");
        \fclose($fp);
    }

    private function megabyteToByte(int $megabyte): int
    {
        return $megabyte * 1024 * 1024;
    }
}
