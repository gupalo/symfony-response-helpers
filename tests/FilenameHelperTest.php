<?php

namespace Gupalo\SymfonyResponseHelpers\Tests;

use Gupalo\SymfonyResponseHelpers\FilenameHelper;
use PHPUnit\Framework\TestCase;

class FilenameHelperTest extends TestCase
{
    public function testGetExtension(): void
    {
        self::assertSame('txt', FilenameHelper::getExtension('file.txt'));
        self::assertSame('txt', FilenameHelper::getExtension('file.file.txt'));
        self::assertSame('txt', FilenameHelper::getExtension('file.file...txt'));
        self::assertSame('txt', FilenameHelper::getExtension('/root/some.path/file.file...txt'));
        self::assertNull(FilenameHelper::getExtension(null));
        self::assertNull(FilenameHelper::getExtension('file'));
        self::assertNull(FilenameHelper::getExtension('/root/some.path/file.file...'));
    }
}
