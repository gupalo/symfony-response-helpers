<?php

namespace Gupalo\SymfonyResponseHelpers\Tests;

use Gupalo\SymfonyResponseHelpers\PublicFileResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

class PublicFileResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $response = PublicFileResponse::create(__DIR__, basename(__FILE__));
        self::assertInstanceOf(BinaryFileResponse::class, $response);
        self::assertSame(200, $response->getStatusCode());
        self::assertFalse($response->getContent());

        ob_start();
        $response->sendContent();
        self::assertStringEqualsFile(__FILE__, ob_get_clean());
    }

    public function testCreate_NoFile(): void
    {
        $response = PublicFileResponse::create(__DIR__, 'unexisting_file');
        self::assertNull($response);
    }

    public function testCreate_NotModified(): void
    {
        $request = (new Request());
        $request->headers->set('if-none-match', '34faedda08f7e2d732cc28a4f1cee72a');

        $response = PublicFileResponse::create(dirname(__DIR__), '.gitignore', $request);
        self::assertNotInstanceOf(BinaryFileResponse::class, $response);
        self::assertSame(304, $response->getStatusCode());
        self::assertSame('', $response->getContent());
    }
}
