<?php

namespace App\Http\Controllers\auth;

use App\Events\verifyAccountEvent;
use App\Http\Controllers\Controller;
use App\Models\otpCode;
use App\Models\User;
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
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|min:3|unique:users',
                'password' => 'required|min:5',
                'confirmpassword' => 'required|same:password',
            ]
        );

        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "massage" => $val->errors()
            ], 400);
        }

        $user['password'] = Hash::make($user['password']);
        User::create($user);
        $otp['otp'] = rand(0001, 9999);
        otpCode::create($otp);

        // Massage For Gmail
        $user['subject'] = 'Verification code';
        $user['otp'] = $otp['otp'];

        verifyAccountEvent::dispatch($user);
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
                'email' => 'required',
                'password' => 'required',
            ]
        );

        if ($val->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $val->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sign In Failed'
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Sign In Successfully',
            'data' => [
                'token' => $token,
                'user_info' => $user,
            ]
        ], 200);
    }

    public function verifyEmail(Request $request)
    {
        # code...
    }
}
