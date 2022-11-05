<?php

namespace App\Repository\User;

interface IUserRepository {
    public function create($data);
    public function where($data);
    public function update($user, $data);
    public function save($user);
}
