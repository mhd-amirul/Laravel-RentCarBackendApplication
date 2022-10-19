<?php

namespace App\Http\Controllers\store;

use App\Helpers\handleFile;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeRequest;
use App\Models\store;
use App\Services\Store\IStoreService;
use Illuminate\Http\Request;

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

    public function updateStore(Request $request, $slug)
    {
        # code...
    }
}
