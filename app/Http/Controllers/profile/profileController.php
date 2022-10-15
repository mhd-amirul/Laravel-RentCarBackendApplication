<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\resetPassword;
use App\Http\Requests\updateProfile;
use App\Models\User;
use App\Services\User\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class profileController extends Controller
{
    private $userService;

    public function __construct(IUserService $userService)
    {
        return [
            $this->userService = $userService,
        ];
    }

    public function profil()
    {
        $user = $this->userService->whereUser(auth()->user()->email);
        if ($user) {
            return response()->json([
                "status" => "OK",
                "data" => $user
            ], 200);
        } else {
            return response()->json([
                "status" => "NOT_FOUND",
                "message" => "user not found"
            ]);
        }
    }

    public function edit(updateProfile $request)
    {
        $this->userService->updateUser(auth()->user()->email, $request);
        $user = $this->userService->whereUser(auth()->user()->email);
        return response()->json([
            "status" => "OK",
            "data" => $user
        ], 200);
    }

    public function resetPassword(resetPassword $request)
    {
        $user = $this->userService->whereUser(auth()->user()->email);
        if (!Hash::check($request["oldpassword"], $user->password)) {
            return response()->json([
                "status" => "BAD_REQUEST",
                "message" => "invalid password"
            ], 400);
        }

        $request["password"] = Hash::make($request["password"]);
        $this->userService->updateUser($user->email, $request);
        return response()->json([
            "status" => "OK",
            "message" => "password has been updated",
        ], 200);
    }
}
