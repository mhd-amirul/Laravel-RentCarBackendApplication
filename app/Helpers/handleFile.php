<?php

namespace App\Helpers;

class handleFile
{
    public static function renameFile($request, $lastPath)
    {
        return [
            "filename" => time().rand(1111,9999).".".$request[$lastPath]->extension(),
            "path" => "storage\image\\".$lastPath
        ];
    }

    public static function addFile($request, $lastPath)
    {
        try {
            if ($request->has($lastPath)) {
                $name = self::renameFile($request, $lastPath);
                $request[$lastPath]->move($name["path"], $name["filename"]);
                return $name["path"]."\\".$name["filename"];
            }
        } catch (\Throwable $th) {
            throw ResponseFormatter::throwErr("addFile Error!");
        }
    }
}
