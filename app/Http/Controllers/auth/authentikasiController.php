<?php

namespace App\Http\Controllers\auth;

use App\Events\verifyAccountEvent;
use App\Http\Controllers\Controller;
use App\Models\otpCode;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authentikasiController extends Controller
{
    public function register(Request $request)
    {
        $user = $request->all();
        $val = Validator::make($user,
            [
                "first_name" => "required",
                "last_name" => "required",
                "email" => "required|email|unique:users",
                "no_hp" => "required|min:3|unique:users",
                "password" => "required|min:5",
                "confirmpassword" => "required|same:password",
            ]
        );

        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => $val->errors()
            ], 400);
        }

        $user["password"] = Hash::make($user["password"]);
        User::create($user);

        $otp = [
            "email" => $user["email"],
            "otp" => rand(1000, 9999)
        ];
        otpCode::create($otp);

        verifyAccountEvent::dispatch($otp);
        return response()->json(
            [
                "code" => 200,
                "status" => "OK",
                "message" => "Sign Up Succesfully",
                "data" => [
                    "first_name" => $user["first_name"],
                    "last_name" => $user["last_name"],
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
