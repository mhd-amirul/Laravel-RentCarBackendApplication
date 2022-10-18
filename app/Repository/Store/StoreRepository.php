<?php

namespace App\Repository\Store;

use App\Models\store;
use App\Repository\Store\IStoreRepository;

class StoreRepository implements IStoreRepository
{
    private $store;
    public function __construct(store $store)
    {
        return $this->store = $store;
    }

    public function create($data)
    {
        return $this->store->create($data);
    }
}
