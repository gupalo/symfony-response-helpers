<?php

namespace Gupalo\SymfonyResponseHelpers;

use Gupalo\DateUtils\DateUtils;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicFileResponse
{
    public static function create(string $dir, string $slug, Request $request = null): ?Response
    {
        $filename = FilenameSanitizer::sanitizePath($dir . '/' . self::removeQueryParams($slug));

        if (!is_file($filename)) {
            return null;
        }

        $etag = md5_file($filename);
        $response = self::getNotModifiedResponse($request, $etag);
        if ($response) {
            return $response;
        }

        return BinaryFileResponse::create($filename, Response::HTTP_OK, [
            'Content-Type' => ContentType::fromFilename($filename),
            'Expires' => DateUtils::addMinutes(30, DateUtils::create())->format('r'),
            'Cache-Control' => 'public, max-age=1800',
            'ETag' => $etag,
        ]);
    }

    private static function removeQueryParams(string $slug): string
    {
        return preg_replace('#[?\#].*$#', '', $slug);
    }

    private static function getNotModifiedResponse(?Request $request, string $etag): ?Response
    {
        $etags = $request ? $request->getETags() : [];

        return (in_array($etag, $etags, true) || in_array(sprintf('"%s"', $etag), $etags, true)) ?
            (new Response())->setNotModified() :
            null;
    }
}
