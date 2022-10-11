<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class profileController extends Controller
{
    public function profil()
    {
        $user = User::where("email", auth()->user()->email)->first();
        if ($user) {
            return response()->json([
                "status" => "OK",
                "data" => $user
            ], 200);
        } else {
            return response()->json([
                "code" => 404,
                "status" => "NOT_FOUND",
                "message" => "user not found"
            ]);
        }
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $user = User::where("email", auth()->user()->email)->first();
        $rules = [];
        if ($request->email != $user->email && $request->email != null) {
            $rules["email"] = "required|email|unique:users";
        }
        if ($request->no_hp != $user->no_hp && $request->no_hp != null) {
            $rules["no_hp"] = "required|min:3|unique:users";
        }

        $val = Validator::make($data,$rules);
        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => $val->errors()
            ], 400);
        }

        $user->update($data);
        return response()->json([
            "code" => 200,
            "status" => "OK",
            "data" => $user
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->all();
        $rules = [
            "oldpassword" => "required",
            "password" => "required|min:5",
            "confirmpassword" => "required|same:password"
        ];

        $val = Validator::make($data, $rules);
        if ($val->fails()) {
            return response()->json([
                "code" => 400,
                "status" => "BAD_REQUEST",
                "message" => $val->errors()
            ], 400);
        }

        $user = User::where("email", auth()->user()->email)->first();
        if (Hash::check($data["oldpassword"], $user->password)) {
            $data["password"] = Hash::make($data["password"]);
            $user->update($data);
            return response()->json([
                "code" => 200,
                "status" => "OK",
                "message" => "password has been updated",
            ], 200);
        }
        return response()->json([
            "code" => 400,
            "status" => "BAD_REQUEST",
            "message" => "invalid password"
        ], 400);
    }
}
