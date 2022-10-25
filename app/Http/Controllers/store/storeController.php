<?php

namespace App\Http\Controllers\store;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Http\Requests\updateStoreRequest;
use App\Services\Store\IStoreService;

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

    public function updateStore(updateStoreRequest $request)
    {
        $store = $this->storeService->whereStore(auth()->user()->email);
        $newStore = $this->storeService->updateStore($store, $request);
        return ResponseFormatter::success([$store, $newStore]);
    }
}
