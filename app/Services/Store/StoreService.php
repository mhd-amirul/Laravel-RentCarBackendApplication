<?php

namespace App\Services\Store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Repository\Store\IStoreRepository;
use App\Services\Store\IStoreService;

class StoreService implements IStoreService
{
    private $storeRepository;
    public function __construct(IStoreRepository $storeRepository)
    {
        return $this->storeRepository = $storeRepository;
    }

    public function createStore($request)
    {
        try {
            $data = $request->all();
            if ($request->has("ktp")) {
                $file = handleFile::image($data["ktp"], "ktp");
                $data["ktp"] = $file["fullpath"];
                $request->ktp->move($file["path"], $file["filename"]);
            }
            if ($request->has("siu")) {
                $file = handleFile::image($data["siu"], "siu");
                $data["siu"] = $file["fullpath"];
                $request->siu->move($file["path"], $file["filename"]);
            }
            if ($request->has("img_owner")) {
                $file = handleFile::image($data["img_owner"], "img_owner");
                $data["img_owner"] = $file["fullpath"];
                $request->img_owner->move($file["path"], $file["filename"]);
            }
            if ($request->has("img_store")) {
                $file = handleFile::image($data["img_store"], "img_store");
                $data["img_store"] = $file["fullpath"];
                $request->img_store->move($file["path"], $file["filename"]);
            }
            $data["user"] = auth()->user()->email;
            $data["slug"] = time() . rand(11111, 99999) . $data["user"];
            $data["coordinate"] = [
                "latitude" => $data["latitude"],
                "longitude" => $data["longitude"]
            ];
            $data["address"] = [
                "village" => $data["village"],
                "city" => $data["city"],
                "province" => $data["province"]
            ];
            return $this->storeRepository->create($data);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }
}
