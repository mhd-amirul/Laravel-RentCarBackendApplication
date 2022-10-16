<?php

namespace App\Http\Controllers\profile;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\resetPassword;
use App\Http\Requests\updateProfile;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Hash;

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
        $user = $this->userService->updateUser(auth()->user()->email, $request);
        return ResponseFormatter::success($user, "Profile has been updated");
    }

    public function resetPassword(resetPassword $request)
    {
        $user = $this->userService->whereUser(auth()->user()->email);
        $check = $this->userService->checkPassword($user, $request);
        if ($check == "invalid") {
            return ResponseFormatter::error(null, "Password not match");
        }
        $request["password"] = Hash::make($request["new_password"]);
        $this->userService->updateUser(auth()->user()->email, $request);
        return ResponseFormatter::success($user, "password has been updated");
    }
}
