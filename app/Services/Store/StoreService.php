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

    public function updateFile($request, $lastPath, $store)
    {
        try {
            if ($request->has($lastPath)) {
                if ($store->ktp) {
                    File::delete($store->ktp);
                }
                $filename = time().rand(1111,9999).".".$request[$lastPath]->extension();
                $path = "storage\image\\".$lastPath;
                $request[$lastPath]->move($path, $filename);
                return $path."\\".$filename;
            }
        } catch (\Exception $th) {
            return ResponseFormatter::throwErr("update file was wrong!");
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
            $data["ktp"] = handleFile::addFile($request,"ktp");
            $data["siu"] = handleFile::addFile($request,"siu");
            $data["img_owner"] = handleFile::addFile($request,"img_owner");
            $data["img_store"] = handleFile::addFile($request,"img_store");
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

    public function updateStore($store, $request)
    {
        $data = $request->all();
        $data["ktp"] = $this->updateFile($request, "ktp", $store);
        $data["siu"] = $this->updateFile($request, "siu", $store);
        $data["img_owner"] = $this->updateFile($request, "img_owner", $store);
        $data["img_store"] = $this->updateFile($request, "img_store", $store);
        return $this->storeRepository->update($store, $data);
    }
}
