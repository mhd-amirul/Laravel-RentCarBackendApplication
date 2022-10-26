<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

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

    public static function updateFile($request, $lastPath, $store)
    {
        try {
            if ($store->ktp) { File::delete($store->ktp); }
            $name = self::renameFile($request, $lastPath);
            $request[$lastPath]->move($name["path"], $name["filename"]);
            return $name["path"]."\\".$name["filename"];
        } catch (\Exception $th) {
            return ResponseFormatter::throwErr("update file was wrong!");
        }
    }
}
