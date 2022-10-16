<?php

namespace App\Http\Controllers\store;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class storeController extends Controller
{
    public function registerStore(Request $request)
    {
        $data = $request->all();
        $rule = [
            "name" => "required",
            "owner" => "required",
            "nik" => "required|digits:16",
            "address" => "required",
            "latitude" => "required",
            "longitude" => "required",
            // "ktp" => "file",
            // "siu" => "file",
            // "img_owner" => "file",
            // "img_store" => "file",
        ];

        $val = Validator::make($data, $rule);
        if ($val->fails()) {
            return ResponseFormatter::error(null, $val->errors());
        }

        // if ($request->file("ktp")) {
        //     $data["ktp"] = $request->file("ktp");
        // }
        $data["slug"] = time() . rand(11111, 99999) . $data["user"];
        $data["user"] = auth()->user()->email;
        $data["coordinate"] = $data["latitude"] . "|" . $data["longitude"];
        // $data = store::create($data);
        return response()->json($data);
    }
}
