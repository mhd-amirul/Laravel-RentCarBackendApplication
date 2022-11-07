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

    public function whereOne($id)
    {
        // return $this->store->where('user', 'exists', ['_id', $id])->first();
        return $this->store->where('user_id', $id)->first();
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

    public function delete($store)
    {
        return $store->delete();
    }
}
