<?php

namespace App\Repository\Store;

interface IStoreRepository {
    public function create($data);
    public function whereOne($id);
    public function update($store, $data);
    public function save($store);
    public function delete($store);
}
