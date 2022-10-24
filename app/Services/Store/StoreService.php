<?php

namespace App\Services\Store;

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

    public function updateStore($store, $request)
    {
        $data = $request->all();
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
        return $this->storeRepository->update($store, $data);
    }
}
