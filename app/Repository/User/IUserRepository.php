<?php

namespace App\Repository\User;

interface IUserRepository {
    public function create($data);
    public function where($data);
}
