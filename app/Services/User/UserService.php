<?php

namespace App\Services\User;

use App\Helpers\ResponseFormatter;
use App\Notifications\emailNotification;
use App\Repository\User\IUserRepository;
use App\Services\User\IUserService;
use Exception;
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
        try {
            $data = $request->all();
            $data["password"] = Hash::make($data["password"]);
            return $this->userRepository->create($data);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "createUser");
        }

    }

    public function whereUser($request)
    {
        try {
            return $this->userRepository->where($request);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "whereUser");
        }
    }

    public function updateUser($user, $request)
    {
        try {
            $data = $request->all();
            return $this->userRepository->update($user, $data);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "updateUser");
        }
    }

    public function checkPassword($user, $request)
    {
        try {
            if (!Hash::check($request->password, $user->password)) {
                return "invalid";
            }
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "checkPassword");
        }
    }

    public function sendMail($user, $otp)
    {
        try {
            return $user->notify(new emailNotification($user, $otp));
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "sendMail");
        }
    }

    public function saveUser($user)
    {
        try {
            return $this->userRepository->save($user);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "saveUser");
        }
    }

    public function logoutUser()
    {
        try {
            return request()->user()->currentAccessToken()->delete();
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "saveUser");
        }
    }
}
