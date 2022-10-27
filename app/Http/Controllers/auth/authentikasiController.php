<?php

namespace App\Http\Controllers\auth;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\signinRequest;
use App\Http\Requests\signupRequest;
use App\Services\Otp\IOtpService;
use App\Services\User\IUserService;
use Illuminate\Http\Request;

class authentikasiController extends Controller
{
    private $userServices, $otpServices;

    public function __construct(IUserService $userServices, IOtpService $otpServices)
    {
        return [
            $this->userServices = $userServices,
            $this->otpServices = $otpServices,
        ];
    }

    public function register(signupRequest $request)
    {
        $user = $this->userServices->createUser($request);
        $otp = $this->otpServices->createOtp($user);
        $this->userServices->sendMail($user, $otp);
        return ResponseFormatter::success($user, "Sign up success");

    }

    public function login(signinRequest $request)
    {
        $user = $this->userServices->whereUser($request->email);
        $checkPass = $this->userServices->checkPassword($user, $request);
        if ($checkPass === 'invalid') {
            return ResponseFormatter::error(null, "Sign in failed");
        }
        $user['token'] = $user->createToken("token")->plainTextToken;
        return ResponseFormatter::success($user, "Sign in success");
    }

    public function verifyEmail(Request $request)
    {
        $user = $this->userServices->whereUser($request->email);
        $otp = $this->otpServices->whereOtp($request->email);
        $verify = $this->otpServices->verifyEmail($user, $otp, $request);
        if ($verify["status"] === "success") {
            $user["email_verified_at"] = $verify["data"];
            $this->userServices->saveUser($user);
            $this->otpServices->deleteOtp($request->email);
            return ResponseFormatter::success($user, "email has verified at ".$user->email_verified_at);
        } elseif ($verify["status"] === "otpfail") {
            return ResponseFormatter::error(null, "invalid otp code");
        } elseif ($verify["status"] === "userfail") {
            return ResponseFormatter::error(null, "user not found");
        }
    }
}
