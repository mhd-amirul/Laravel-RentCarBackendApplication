<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addCarRequest;
use App\Models\car;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class carController extends Controller
{
    public function addCar(addCarRequest $request)
    {
        $store = store::where("user_id", auth()->user()->_id)->first();
        $data = $request->all();
        $data["image1"] = handleFile::addFile($request, "image1", "car");
        $data["slug"] = time() . rand(11111, 99999) . $data["brand"];
        $data["shop_id"] = $store->id;
        $data = car::create($data);
        return ResponseFormatter::success($data);
    }
}
