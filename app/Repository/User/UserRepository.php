<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\User\IUserRepository;

class UserRepository implements IUserRepository
{
    private $user;
    public function __construct(User $user)
    {
        return $this->user = $user;
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function where($data)
    {
        return $this->user->where('email', $data)->first();
    }

    public function update($email, $data)
    {
        $user = $this->where($email);
        $user->update($data);
        return $user;
    }

    public function save($user)
    {
        return $user->save();
    }
}
