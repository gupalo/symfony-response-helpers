<?php

namespace Gupalo\SymfonyResponseHelpers\Tests;

use Gupalo\SymfonyResponseHelpers\ContentType;
use PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    public function testFromExtension(): void
    {
        self::assertSame('application/javascript', ContentType::fromExtension('js'));
        self::assertSame('text/plain', ContentType::fromExtension('unknown'));
        self::assertSame('text/plain', ContentType::fromExtension(null));
        self::assertSame('application/javascript', ContentType::fromExtension('JS'));
    }

    public function testFromFilename(): void
    {
        self::assertSame('application/javascript', ContentType::fromFilename('/root/path/file.js'));
        self::assertSame('text/plain', ContentType::fromFilename('/root/path/file'));
        self::assertSame('text/plain', ContentType::fromFilename(null));
        self::assertSame('application/javascript', ContentType::fromFilename('file.JS'));
    }
}
