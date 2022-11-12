<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\car;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class carController extends Controller
{
    public function addCar(Request $request)
    {
        $store = store::where("user_id", auth()->user()->_id)->first();
        $data = $request->all();
        $rules = [
            "plat" => "required|min:1",
            "brand" => "required|max:20",
            "model" => "required|max:20",
            "varian" => "required|max:10",
            "transmisi" => "required|max:10",
            "tahun" => "required",
            "warna" => "required|max:20",
            "cc" => "required|max:10",
            "seater" => "required|max:2",
            "bbm" => "required|max:20",
            "harga" => "required|max:20",
            "image1" => "required|file"
        ];

        $val = Validator::make($data, $rules);
        if ($val->fails()) {
            return response()->json($val->errors());
        }
        $data["image1"] = handleFile::addFile($request, "image1", "car");
        $data = car::create($data);
        return ResponseFormatter::success($data);
    }
}
