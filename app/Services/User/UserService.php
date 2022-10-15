<?php

namespace App\Services\User;

use App\Helpers\ResponseFormatter;
use App\Notifications\emailNotification;
use App\Repository\User\IUserRepository;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Hash;
use DateTime;

class UserService implements IUserService
{
    private $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        return $this->userRepository = $userRepository;
    }

    public function createUser($request)
    {
        try {
            $data = $request->all();
            $data["password"] = Hash::make($data["password"]);
            return $this->userRepository->create($data);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }

    }

    public function whereUser($request)
    {
        try {
            return $this->userRepository->where($request);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function updateUser($user, $request)
    {
        try {
            return $this->userRepository->update($user, $request);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function checkPassword($user, $request)
    {
        try {
            if (!$user || !Hash::check($request->password, $user->password)) {
                return "invalid";
            }
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function sendMail($user, $otp)
    {
        try {
            return $user->notify(new emailNotification($user, $otp));
        } catch (\Throwable $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function saveUser($user)
    {
        try {
            return $this->userRepository->save($user);
        } catch (\Throwable $th) {
            throw ResponseFormatter::throwErr();
        }
    }
}
