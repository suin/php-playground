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
        \ftruncate($fp, $this->megabyteToByte($megabyte));
        \fclose($fp);
    }

    private function megabyteToByte(int $megabyte): int
    {
        return $megabyte * 1024 * 1024;
    }
}
