<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Models\store;
use App\Services\Store\IStoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return ResponseFormatter::success($store, "success");
    }

    public function agreementStore()
    {
        # make user to agree with app condition and term

    }

    public function updateStore(Request $request)
    {
        $store = store::where("user", request()->query("user"))->first();
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
        if ($request->has("ktp")) {
            if ($store->ktp) {
                Storage::delete($store->ktp);
                return response()->json($store->ktp);
            }
            // $file = handleFile::image($data["ktp"], "ktp");
            // $data["ktp"] = $file["fullpath"];
            // $request->ktp->move($file["path"], $file["filename"]);
        }
        return response()->json([$data, $store]);
    }
}
