<?php

namespace App\Services\User;

interface IUserService {
    public function createUser($request);
    public function whereUser($request);
}
