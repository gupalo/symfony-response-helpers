<?php

namespace Gupalo\SymfonyResponseHelpers;

class FilenameHelper
{
    public static function getExtension(?string $filename): ?string
    {
        return preg_match('#\.([^./]+)($|\?|\#)#', $filename, $m) ? $m[1] : null;
    }
}
