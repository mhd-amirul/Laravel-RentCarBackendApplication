<?php

namespace App\Repository\User;

interface IUserRepository {
    public function create($data);
    public function where($data);
    public function update($email, $data);
    public function save($user);
}
