<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\File;

class handleFile
{
    public static function renameFile($request, $lastPath, $type)
    {
        try {
            return [
                "filename" => time().rand(1111,9999).".".$request[$lastPath]->extension(),
                "path" => "storage\\".$type."\\".$lastPath
            ];
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "renameFile");
        }

    }

    public static function addFile($request, $lastPath, $type = "shop")
    {
        try {
            if ($request->has($lastPath)) {
                $name = self::renameFile($request, $lastPath, $type);
                $request[$lastPath]->move($name["path"], $name["filename"]);
                return $name["path"]."\\".$name["filename"];
            }
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "addFile");
        }
    }

    public static function updateFile($request, $lastPath, $store, $type = "image")
    {
        try {
            if ($store[$lastPath]) { File::delete($store[$lastPath]); }
            $name = self::renameFile($request, $lastPath, $type);
            $request[$lastPath]->move($name["path"], $name["filename"]);
            return $name["path"]."\\".$name["filename"];
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "updateFile");
        }
    }

    public static function deleteFile($lastPath, $store)
    {
        try {
            File::delete($store[$lastPath]);
            return true;
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "updateFile");
        }
    }
}
