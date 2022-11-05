<?php

namespace App\Services\Store;

interface IStoreService {
    public function createStore($request);
    public function whereStore($user);
    public function updateStore($store, $data);
    public function saveStore($store);
    public function deleteStore();
}
