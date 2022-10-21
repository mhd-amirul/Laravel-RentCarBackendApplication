<?php

namespace App\Repository\Store;

interface IStoreRepository {
    public function create($data);
    public function where($user);
    // public function update($user, $data);
}
