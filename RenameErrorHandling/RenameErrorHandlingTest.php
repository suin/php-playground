<?php

declare(strict_types=1);

namespace Suin\Playground\RenameErrorHandling;

use ErrorException;
use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;
use Suin\Playground\TestingService\TestDirectory;

final class RenameErrorHandlingTest extends TestCase
{
    /**
     * @var string|TestDirectory
     */
    private $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testDirectory = TestDirectory::forTestCase($this);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->testDirectory->purgeOnPass($this);
    }

    /**
     * @test
     */
    public function rename_fails_with_file_not_found(): void
    {
        $notFoundFile = $this->testDirectory . '/not-found.txt';
        self::assertFileNotExists($notFoundFile);
        $this->expectException(Warning::class);
        $this->expectExceptionMessageRegExp('/No such file or directory/');
        \rename($notFoundFile, $this->testDirectory . '/new-name.txt');
    }

    /**
     * @test
     */
    public function rename_fails_when_new_path_directory_not_exists(): void
    {
        $oldPath = $this->testDirectory . '/old.txt';
        \file_put_contents($oldPath, '');
        self::assertFileExists($oldPath);

        $newDir = $this->testDirectory . '/new-dir';
        $newPath = $newDir . '/new.txt';
        self::assertDirectoryNotExists($newDir);

        $this->expectException(Warning::class);
        $this->expectExceptionMessageRegExp('/No such file or directory/');
        \rename($oldPath, $newPath);
    }

    /**
     * @test
     */
    public function rename_fails_with_no_permission_enough(): void
    {
        $oldDir = $this->testDirectory . '/old-dir';
        $oldPath = $oldDir . '/old.txt';
        \mkdir($oldDir);
        \file_put_contents($oldPath, '');
        \chmod($oldDir, 0555);
        self::assertDirectoryExists($oldDir);
        self::assertDirectoryIsReadable($oldDir);
        self::assertDirectoryNotIsWritable($oldDir);
        self::assertFileExists($oldPath);

        $newPath = $this->testDirectory . '/new.txt';
        $this->expectException(Warning::class);
        $this->expectExceptionMessage(
            "rename(${oldPath},${newPath}): Permission denied"
        );
        \rename($oldPath, $newPath);
    }

    /**
     * @test
     */
    public function capture_rename_error_with_custom_error_handler(): void
    {
        $notFoundFile = $this->testDirectory . '/not-found.txt';
        self::assertFileNotExists($notFoundFile);
        $exception = null;

        \set_error_handler(
            function (
                int $severity,
                string $message,
                string $file,
                int $line
            ): void {
                throw new ErrorException($message, 0, $severity, $file, $line);
            }
        );

        try {
            \rename($notFoundFile, $this->testDirectory . '/new-name.txt');
        } catch (ErrorException $exception) {
        } finally {
            \restore_error_handler();
        }
        self::assertInstanceOf(ErrorException::class, $exception);
        self::assertContains(
            'No such file or directory',
            $exception->getMessage()
        );
    }
}
