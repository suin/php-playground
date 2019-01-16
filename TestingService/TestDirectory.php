<?php

declare(strict_types=1);

namespace Suin\Playground\TestingService;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\BaseTestRunner;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

final class TestDirectory
{
    private const BASE_DIR = 'php-playground';

    /**
     * @var string
     */
    private $baseDir;

    /**
     * @var string
     */
    private $directoryName;

    public function __construct(string $directoryName)
    {
        $this->baseDir = \sys_get_temp_dir() . '/' . self::BASE_DIR;
        $this->directoryName = $directoryName;
        $this->createDirectory($this->getPath());
    }

    public function __toString(): string
    {
        return $this->getPath();
    }

    public static function forTestCase(TestCase $testCase): self
    {
        $className = \str_replace('\\', '.', \get_class($testCase));
        $testCaseName = $testCase->getName(false);
        return new self($className . '.' . $testCaseName);
    }

    public function getPath(): string
    {
        return $this->baseDir . '/' . $this->directoryName;
    }

    public function purge(): void
    {
        $this->refineDirectoryPermissionRecursively();
        $this->deleteFilesRecursively();
    }

    public function purgeOnPass(TestCase $testCase): void
    {
        if ($testCase->getStatus() === BaseTestRunner::STATUS_PASSED) {
            $this->purge();
        }
    }

    private function createDirectory(string $path): void
    {
        if (!\is_dir($path)
            && !\mkdir($path, 0777, true)
            && !\is_dir($path)) {
            throw new RuntimeException(
                "Unable to create test directory: {$path}"
            );
        }
    }

    private function refineDirectoryPermissionRecursively(): void
    {
        /** @noinspection OneTimeUseVariablesInspection */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->getPath(),
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDir() && !$file->isWritable()) {
                \chmod($file->getPathname(), 0755);
            }
        }
    }

    private function deleteFilesRecursively(): void
    {
        /** @noinspection OneTimeUseVariablesInspection */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->getPath(),
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDir() === true) {
                \rmdir($file->getPathname());
            } else {
                \unlink($file->getPathname());
            }
        }

        \rmdir($this->getPath());
    }
}
