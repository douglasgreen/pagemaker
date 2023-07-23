<?php

namespace PageMakerDev\Utility\Test;

use PageMakerDev\LibraryException;
use PageMakerDev\Utility\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testAddTrailingSlash(): void
    {
        $path = 'testDirectory';
        $expectedPath = 'testDirectory' . DIRECTORY_SEPARATOR;
        $this->assertSame($expectedPath, File::addTrailingSlash($path));
    }

    public function testAddTrailingSlashAlreadyPresent(): void
    {
        $path = 'testDirectory' . DIRECTORY_SEPARATOR;
        $this->assertSame($path, File::addTrailingSlash($path));
    }

    public function testFindProjectRoot(): void
    {
        $projectRoot = File::findProjectRoot();
        $this->assertFileExists($projectRoot . '/composer.json');
    }
}
