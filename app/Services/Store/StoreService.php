<?php

namespace App\Services\Store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Repository\Store\IStoreRepository;
use App\Services\Store\IStoreService;
use Illuminate\Support\Facades\File;

class StoreService implements IStoreService
{
    private $storeRepository;
    public function __construct(IStoreRepository $storeRepository)
    {
        return $this->storeRepository = $storeRepository;
    }

    public function whereStore($user)
    {
        return $this->storeRepository->where($user);
    }

    public function createStore($request)
    {
        try {
            $data = $request->all();
            $data["ktp"] = handleFile::addFile($request,"ktp");
            $data["siu"] = handleFile::addFile($request,"siu");
            $data["img_owner"] = handleFile::addFile($request,"img_owner");
            $data["img_store"] = handleFile::addFile($request,"img_store");
            $data["user"] = auth()->user()->email;
            $data["slug"] = time() . rand(11111, 99999) . $data["user"];
            $data["status"] = "disable";
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
            throw ResponseFormatter::throwErr($th);
        }
    }

    public function updateStore($store, $request)
    {
        $data = $request->all();
        $data["coordinate"] = $store->coordinate;
        $data["address"] = $store->address;
        if ($request->has("ktp")) {
            $data["ktp"] = handleFile::updateFile($request, "ktp", $store);
        }
        if ($request->has("siu")) {
            $data["siu"] = handleFile::updateFile($request, "siu", $store);
        }
        if ($request->has("img_owner")) {
            $data["img_owner"] = handleFile::updateFile($request, "img_owner", $store);
        }
        if ($request->has("img_store")) {
            $data["img_store"] = handleFile::updateFile($request, "img_store", $store);
        }

        if ($request->has("latitude")) {
            $data["coordinate"]["latitude"] = $request->latitude;
        }
        if ($request->has("longitude")) {
            $data["coordinate"]["longitude"] = $request->longitude;
        }

        if ($request->has("village")) {
            $data["address"]["village"] = $request->village;
        }
        if ($request->has("city")) {
            $data["address"]["city"] = $request->city;
        }
        if ($request->has("province")) {
            $data["address"]["province"] = $request->province;
        }
        return $this->storeRepository->update($store, $data);
    }
}
