<?php

namespace App\Helpers;

class handleFile
{
    protected static $feedback = [
        "path" => "\\",
        "filename" => "error",
        "fullpath" => "error"
    ];

    public static function image($filename, $lastPath, $path = "storage\image\\")
    {
        $filename = time().rand(1111,9999).".".$filename->extension();
        self::$feedback["path"] = $path.$lastPath;
        self::$feedback["filename"] = $filename;
        self::$feedback["fullpath"] = $path.$lastPath."\\".$filename;
        return self::$feedback;
    }
}
