<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addCarRequest;
use App\Http\Requests\updateCarRequest;
use App\Models\car;
use App\Models\store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class carController extends Controller
{
    public function getCar()
    {
        # code...
    }

    public function addCar(addCarRequest $request)
    {
        $store = store::where("user_id", auth()->user()->_id)->first();
        $data = $request->all();
        $data["image1"] = handleFile::addFile($request, "image1", "car");
        $data["slug"] = time() . rand(11111, 99999) . str_replace(" ", "", $store["name"]);
        $data["shop_id"] = $store->id;
        $data = car::create($data);
        return ResponseFormatter::success($data);
    }

    public function updateCar(updateCarRequest $request)
    {
        $db = car::where("_id", $request->car_id)->first();
        $data = $request->all();
        if ($request->has("image1")) {
            $data["image1"] = handleFile::updateFile($request, "image1", $db);
        }
        $db->update($data);
        return ResponseFormatter::success($db, "the car has been updated");
    }

    public function deleteCar()
    {
        # code...
    }
}
