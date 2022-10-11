<?php

namespace App\Http\Controllers\auth;

use App\Events\verifyAccountEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\signupRequest;
use App\Models\otpCode;
use App\Models\User;
use App\Notifications\emailNotification;
use App\Services\Otp\IOtpService;
use App\Services\User\IUserService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authentikasiController extends Controller
{
    private $userServices;
    public function __construct(IUserService $userServices,)
    {
        $userServices = $this->userServices = $userServices;
        return [
            $userServices,
        ];
    }
    public function register(signupRequest $request)
    {
        $user = $this->userServices->createUser($request);
        return response()->json([
            "code" => 200,
            "status" => "OK",
            "message" => "Sign Up Succesfully",
            "data" => [
                "name" => $user["first_name"] . ' ' . $user["last_name"],
                "email" => $user["email"],
                "no_hp" => $user["no_hp"],
            ],
        ], 200);
    }

    public function login(Request $request)
    {
        $val = validator::make($request->all(),
            [
                "email" => "required",
                "password" => "required",
            ]
        );

        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => $val->errors()
            ], 400);
        }

        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => "Sign in failed"
            ], 400);
        }

        if ($user->email_verified_at == null) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => "please verify your email to get started",
            ], 400);
        } else {
            $token = $user->createToken("token")->plainTextToken;
            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => [
                    "token" => $token,
                    "user" => $user,
                ]
            ], 200);
        }
    }

    public function verifyEmail(Request $request)
    {
        $val = Validator::make($request->all(),
            [
                "email" => "required",
                "otp" => "required",
            ]
        );

        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "massage" => $val->errors()
            ], 400);
        }

        $user = User::where("email", $request->email)->first();
        $otp = otpCode::where("otp", $request->otp)->first();
        if ($user) {
            if ($otp) {
                if ($user->email == $otp->email) {
                    $user->email_verified_at = new DateTime();
                    $user->save();
                    $otp->delete();
                    return response()->json([
                        "code" => 200,
                        "status" => "OK",
                        "message" => "email has verified at ".$user->email_verified_at
                    ], 200);
                }
            } else {
                return response()->json([
                    "code" => 400,
                    "status" => "BAD_REQUEST",
                    "message" => "invalid otp code"
                ], 400);
            }
        } else {
            return response()->json([
                "code" => 404,
                "status" => "NOT_FOUND",
                "message" => "user not found"
            ], 404);
        }
    }
}
