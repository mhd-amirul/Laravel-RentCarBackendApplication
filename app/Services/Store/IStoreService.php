<?php

namespace App\Services\Store;

interface IStoreService {
    public function createStore($request);
    public function whereStore($user);
    public function addFile($request, $lastPath);
    // public function updateFile();
    // public function renameFileandPath();
}
