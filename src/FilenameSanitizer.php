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

    public static function sanitizePath(string $filename): string
    {
        $filename = str_replace('\\', '/', $filename);
        $infinity = 100;
        do {
            $filename = preg_replace('#[\\\\"*?<>|]+#', '-', $filename);
            $filename = preg_replace('#([\\\\/].*):#', '$1', $filename);
            $filename = preg_replace('#/\.*/+#', '/', $filename);
            $filename = preg_replace('#^\.+#', '', $filename);
        } while ($infinity-- > 0 || !self::validatePath($filename) || preg_match('#/\.*/#', $filename));

        return $filename;
    }

    public static function sanitizeFilename(string $filename): string
    {
        return preg_replace('#[\\\\/:"*?<>|]+#', '-', $filename);
    }
}
