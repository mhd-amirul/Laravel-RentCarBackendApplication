<?php

namespace App\Services\User;

use App\Repository\User\IUserRepository;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    private $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        return $this->userRepository = $userRepository;
    }

    public function createUser($request)
    {
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        return $this->userRepository->create($data);
    }

    public function whereUser($request)
    {
        return $this->userRepository->where($request);
    }
}
