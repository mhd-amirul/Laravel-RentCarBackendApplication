<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Http\Requests\updateStoreRequest;
use App\Http\Requests\userAgreementRequest;
use App\Services\Store\IStoreService;
use App\Services\User\IUserService;
use App\Services\userAgreement\IUserAgreementService;

class storeController extends Controller
{
    private $storeService, $userService, $userAgreementService;

    public function __construct(IStoreService $storeService, IUserService $userService, IUserAgreementService $userAgreementService)
    {
        return [
            $this->storeService = $storeService,
            $this->userService = $userService,
            $this->userAgreementService = $userAgreementService
        ];
    }

    public function registerStore(storeRequest $request)
    {
        $store = $this->storeService->createStore($request);
        return ResponseFormatter::success($store, "Store has been registered!");
    }

    public function agreementStore(userAgreementRequest $request)
    {
        # make user to agree with app condition and term
        $store = $this->storeService->whereStore(auth()->user()->email);
        $userAgreement = $this->userAgreementService->whereUserAgreement(auth()->user()->email);
        if ($store) {
            if (!$userAgreement) {
                $newuserAgreement = $this->userAgreementService->createUserAgreement($request);
                if ($newuserAgreement) {
                    $store["status"] = 1;
                    $this->storeService->saveStore($store);
                    return ResponseFormatter::success($newuserAgreement);
                }
            }
            return ResponseFormatter::error($userAgreement, "This user already agree with our user service and privacy term", 400);
        }
        return ResponseFormatter::error(null, "store didnt exists!");
    }

    public function updateStore(updateStoreRequest $request)
    {
        $store = $this->storeService->whereStore(auth()->user()->email);
        $newStore = $this->storeService->updateStore($store, $request);
        return ResponseFormatter::success([$newStore]);
    }

    public function deleteStore()
    {
        $store = $this->storeService->whereStore(auth()->user()->email);
        $agreement = $this->userAgreementService->whereUserAgreement(auth()->user()->email);
        $store->ktp ? handleFile::deleteFile("ktp", $store) : null;
        // if ($store->ktp) {
        //     handleFile::deleteFile("ktp", $store);
        // }
        if ($store->siu) {
            handleFile::deleteFile("siu", $store);
        }
        if ($store->img_owner) {
            handleFile::deleteFile("img_owner", $store);
        }
        if ($store->img_store) {
            handleFile::deleteFile("img_store", $store);
        }
        // $store->delete();
        // $userAgreement->delete();
        return ResponseFormatter::success([$agreement, $store], "the store has been deleted!");
    }
}
