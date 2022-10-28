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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class storeController extends Controller
{
    private $storeService, $userService;

    public function __construct(IStoreService $storeService, IUserService $userService)
    {
        return [
            $this->storeService = $storeService,
            $this->userService = $userService
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
        $request["user"] = arrNested::userInformation(auth()->user());
        $request["status"] = $request->status;
        $request["description"] = "This user agree with our user service and privacy term";
        $store = store::where("user", "exists", ["email" => $request["user"]["email"]])->first();
        $store["status"] = 1;
        return response()->json($store);
        $user = userAgreement::create($request);
    }

    public function updateStore(updateStoreRequest $request)
    {
        $store = $this->storeService->whereStore(auth()->user()->email);
        $newStore = $this->storeService->updateStore($store, $request);
        return ResponseFormatter::success([$newStore]);
    }
}
