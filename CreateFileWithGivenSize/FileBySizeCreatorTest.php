<?php

declare(strict_types=1);

namespace Suin\Playground\CreateFileWithGivenSize;

use PHPUnit\Framework\TestCase;
use Suin\Playground\TestingService\TestDirectory;

final class FileBySizeCreatorTest extends TestCase
{
    /**
     * @var TestDirectory
     */
    private $directory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->directory = TestDirectory::forTestCase($this);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->directory->purge();
    }

    /**
     * @test
     */
    public function create_128_megabytes_file(): void
    {
        $filename = $this->directory . '/128m';
        $fileCreator = new FileBySizeCreator();
        $fileCreator->createFileWithMegabyte($filename, 128);
        self::assertFileSizeWithMegabyte(128, $filename);
    }

    private static function assertFileSizeWithMegabyte(
        int $expectedMegabyte,
        string $filename
    ): void {
        self::assertSame($expectedMegabyte * 1024 * 1024, \filesize($filename));
    }
}
