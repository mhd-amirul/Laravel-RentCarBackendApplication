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
        $user = User::where('email', auth()->user()->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Profile Not Found'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Information of User',
            'data' => $user
        ], 200);
    }

    public function edit(Request $request)
    {
        $user = User::where('email', auth()->user()->email)->first();
        $rules = [];
        if ($request->email != $user->email && $request->email != null) {
            $rules['email'] = 'required|email|unique:users';
        }
        if ($request->no_hp != $user->no_hp && $request->no_hp != null) {
            $rules['no_hp'] = 'required|min:3|unique:users';
        }

        $val = Validator::make($request->all(),$rules);
        if ($val->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $val->errors()
            ]);
        }
        $data = $request->all();
        $user->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Information have been Updated',
            'new_information' => $user
        ]);

    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'oldpassword' => 'required',
            'password' => 'required|min:5',
            'confirmpassword' => 'required|same:password'
        ];

        $val = Validator::make($request->all(), $rules);
        if ($val->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $val->errors()
            ]);
        }

        $data = $request->all();
        $user = User::where('email', auth()->user()->email)->first();
        if (Hash::check($data['oldpassword'], $user->password)) {
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Password have been Updated',
                'new_information' => $user
            ], 200);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Password not Valid'
        ]);
    }
}
