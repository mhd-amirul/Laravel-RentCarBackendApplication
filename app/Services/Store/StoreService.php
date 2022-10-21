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

    public function addFile($request, $lastPath)
    {
        try {
            if ($request->has($lastPath)) {
                $filename = time().rand(1111,9999).".".$request[$lastPath]->extension();
                $path = "storage\image\\".$lastPath;
                $request[$lastPath]->move($path, $filename);
                return $path."\\".$filename;
            }
        } catch (\Throwable $th) {
            throw ResponseFormatter::throwErr("addFile Error!");
        }
    }

    public function whereStore($user)
    {
        return $this->storeRepository->where($user);
    }

    public function createStore($request)
    {
        try {
            $data = $request->all();
            $data["ktp"] = $this->addFile($request, "ktp");
            $data["siu"] = $this->addFile($request, "siu");
            $data["img_owner"] = $this->addFile($request, "img_owner");
            $data["img_store"] = $this->addFile($request, "img_store");
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
            throw ResponseFormatter::throwErr("createStore Error!");
        }
    }

    public function updateStore($user)
    {
        return $this->whereStore($user);
    }
}
