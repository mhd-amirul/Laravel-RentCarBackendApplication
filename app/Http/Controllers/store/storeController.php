<?php

namespace App\Http\Controllers\store;

use App\Helpers\arrNested;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Http\Requests\updateStoreRequest;
use App\Http\Requests\userAgreementRequest;
use App\Models\store;
use App\Models\userAgreement;
use App\Services\Store\IStoreService;
use App\Services\User\IUserService;
use App\Services\userAgreement\IUserAgreementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $userAgreement = $this->userAgreementService->whereUserAgreement(auth()->user()->email);
        if (!$userAgreement) {
            $userAgreement = $this->userAgreementService->createUserAgreement($request);
            if ($userAgreement["section"] === 1) {
                $store = $this->storeService->whereStore(auth()->user()->email);
                $store["status"] = 1;
                $this->storeService->saveStore($store);
                return ResponseFormatter::success($userAgreement["data"]);
            }
        }
        return ResponseFormatter::error($userAgreement, "This user already agree with our user service and privacy term", 400);
    }

    public function updateStore(updateStoreRequest $request)
    {
        $store = $this->storeService->whereStore(auth()->user()->email);
        $newStore = $this->storeService->updateStore($store, $request);
        return ResponseFormatter::success([$newStore]);
    }
}
