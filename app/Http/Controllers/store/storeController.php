<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Models\store;
use App\Services\Store\IStoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class storeController extends Controller
{
    private $storeService;

    public function __construct(IStoreService $storeService)
    {
        return [
            $this->storeService = $storeService
        ];
    }

    public function registerStore(storeRequest $request)
    {
        $store = $this->storeService->createStore($request);
        return ResponseFormatter::success($store, "Store has been registered!");
    }

    public function agreementStore()
    {
        # make user to agree with app condition and term

    }

    public function updateStore(Request $request)
    {
        $store = store::where("user", auth()->user()->email)->first();
        $data = $request->all();
        $rule = [
            "name" => "nullable|min:5|max:20",
            "owner" => "nullable|min:5|max:20",
            "nik" => "nullable|digits:16|unique:stores,nik",
            "ktp" => "nullable|mimes:png,jpg|max:2048",
            "siu" => "nullable|mimes:png,jpg|max:2048",
            "img_owner" => "nullable|mimes:png,jpg|max:2048",
            "img_store" => "nullable|mimes:png,jpg|max:2048",
        ];
        $val = Validator::make($data, $rule);
        if ($val->fails()) {
            return ResponseFormatter::error(null, $val->errors());
        }
        if ($request->has("ktp")) {
            if ($store->ktp) {
                File::delete($store->ktp);
            }
            $filename = time().rand(1111,9999).".".$request["ktp"]->extension();
            $path = "storage\image\ktp";
            $data["ktp"] = $path."\\".$filename;
            $request->ktp->move($path, $filename);
        }
        if ($request->has("siu")) {
            if ($store->siu) {
                File::delete($store->siu);
            }
            $filename = time().rand(1111,9999).".".$request["siu"]->extension();
            $path = "storage\image\siu";
            $data["siu"] = $path."\\".$filename;
            $request->siu->move($path, $filename);
        }
        if ($request->has("img_owner")) {
            if ($store->img_owner) {
                File::delete($store->img_owner);
            }
            $filename = time().rand(1111,9999).".".$request["img_owner"]->extension();
            $path = "storage\image\img_owner";
            $data["img_owner"] = $path."\\".$filename;
            $request->img_owner->move($path, $filename);
        }
        if ($request->has("img_store")) {
            if ($store->img_store) {
                File::delete($store->img_store);
            }
            $filename = time().rand(1111,9999).".".$request["img_store"]->extension();
            $path = "storage\image\img_store";
            $data["img_store"] = $path."\\".$filename;
            $request->img_store->move($path, $filename);
        }

        $store->update($data);
        return response()->json([$data, $store]);
    }
}
