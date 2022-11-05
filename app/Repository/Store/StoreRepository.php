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

    public function where($user)
    {
        return $this->store->where('user', 'exists', ['email', $user])->first();
    }

    public function update($store, $data)
    {
        $store->update($data);
        return $store;
    }

    public function save($store)
    {
        return $store->save();
    }

    public function delete()
    {
        $this->store = $this->where(auth()->user()->email);
        return $this->store->delete();
    }
}
