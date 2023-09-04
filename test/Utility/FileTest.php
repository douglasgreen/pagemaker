<?php

namespace PageMaker\Utility\Test;

use PageMaker\LibraryException;
use PageMaker\Utility\File;
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
