<?php

namespace Gupalo\SymfonyResponseHelpers\Tests;

use Gupalo\SymfonyResponseHelpers\FilenameSanitizer;
use PHPUnit\Framework\TestCase;

class FilenameSanitizerTest extends TestCase
{
    public function testValidatePath(): void
    {
        self::assertTrue(FilenameSanitizer::validatePath('/root/test/file.txt'));
        self::assertTrue(FilenameSanitizer::validatePath('c:\\test\\subfolder\\file.txt'));
        self::assertFalse(FilenameSanitizer::validatePath('/root/"test"/file.txt'));
        self::assertFalse(FilenameSanitizer::validatePath('/root:test/file.txt'));
    }

    public function testValidateFilename(): void
    {
        self::assertTrue(FilenameSanitizer::validateFilename('file.txt'));
        self::assertTrue(FilenameSanitizer::validateFilename('Юникод🚗.txt'));
        self::assertTrue(FilenameSanitizer::validateFilename('fil..est.txt'));
        self::assertFalse(FilenameSanitizer::validateFilename('file:test.txt'));
        self::assertFalse(FilenameSanitizer::validateFilename('file\\test.txt'));
    }

    public function testSanitizePath(): void
    {
        self::assertSame('/root/test/file.txt', FilenameSanitizer::sanitizePath('/root/test/file.txt'));
        self::assertSame('c:/test/subfolder/file.txt', FilenameSanitizer::sanitizePath('c:\\test\\subfolder\\file.txt'));
        self::assertSame('/roottest/file.txt', FilenameSanitizer::sanitizePath('/root:test/file.txt'));
        self::assertSame('/root/test/file.txt', FilenameSanitizer::sanitizePath('/root/../test/file.txt'));
        self::assertSame('/root/test/file.txt', FilenameSanitizer::sanitizePath('../root/.../././../../test/file.txt'));
    }

    public function testSanitizeFilename(): void
    {
        self::assertSame('strange-file.txt', FilenameSanitizer::sanitizeFilename('strange/file.txt'));
        self::assertSame('strange-file.txt', FilenameSanitizer::sanitizeFilename('strange\\file.txt'));
        self::assertSame('file.txt', FilenameSanitizer::sanitizeFilename('file.txt'));
        self::assertSame('Юникод🚗.txt', FilenameSanitizer::sanitizeFilename('Юникод🚗.txt'));
        self::assertSame('fil..est.txt', FilenameSanitizer::sanitizeFilename('fil..est.txt'));
        self::assertSame('file-test.txt', FilenameSanitizer::sanitizeFilename('file:test.txt'));
    }
}
