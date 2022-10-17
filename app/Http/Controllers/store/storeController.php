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
            "village" => "required",
            "city" => "required",
            "province" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "ktp" => "file",
            "siu" => "file",
            "img_owner" => "file",
            "img_store" => "file",
        ];

        $val = Validator::make($data, $rule);
        if ($val->fails()) {
            return ResponseFormatter::error(null, $val->errors());
        }

        if ($request->has("ktp")) {
            $filename = time().rand(1111,9999).".".$request->ktp->extension();
            $destinationPath = "storage\image";
            $data["ktp"] = $destinationPath."\\".$filename;
            $request->ktp->move($destinationPath, $filename);
        }

        $data["slug"] = time() . rand(11111, 99999) . $data["user"];
        $data["user"] = auth()->user()->email;
        $data["coordinate"] = [
            "latitude" => $data["latitude"],
            "longitude" => $data["longitude"]
        ];
        $data["address"] = [
            "village" => $data["village"],
            "city" => $data["city"],
            "province" => $data["province"]
        ];
        // $data = store::create($data);
        return response()->json($data);
    }
}
