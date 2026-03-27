<?php

namespace Gupalo\SymfonyResponseHelpers;

class FilenameSanitizer
{
    public static function validatePath(string $filename): bool
    {
        if (preg_match('#[\"*?<>|]+#', $filename)) {
            return false;
        }
        if (preg_match('#[\\\\/].*:#', $filename)) {
            return false;
        }

        return true;
    }

    public static function validateFilename(string $filename): bool
    {
        return !preg_match('#[\\\\/:"*?<>|]+#', $filename);
    }

    /** @noinspection UnnecessaryCastingInspection */
    public static function sanitizePath(string $filename): string
    {
        $filename = str_replace('\\', '/', $filename);
        $infinity = 100;
        do {
            $filename = (string)preg_replace('#[\\\\"*?<>|]+#', '-', $filename);
            $filename = (string)preg_replace('#([\\\\/].*):#', '$1', $filename);
            $filename = (string)preg_replace('#/\.*/+#', '/', $filename);
            $filename = ltrim($filename, '.');
        } while ($infinity-- > 0 || !self::validatePath($filename) || preg_match('#/\.*/#', $filename));

        return $filename;
    }

    /** @noinspection UnnecessaryCastingInspection */
    public static function sanitizeFilename(string $filename): string
    {
        return (string)preg_replace('#[\\\\/:"*?<>|]+#', '-', $filename);
    }
}
