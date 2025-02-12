<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        //check user
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        //check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password is not match'
            ], 404);
        }

        //generate token
        $token = $user->createToken('Bearer Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::created([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->newPassword)
        ]);
        $cek_email = User::where('email', $request->email);
        if ($cek_email == true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Redudan'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successfully'
        ]);
    }

    public function cari_user(Request $request)
    {
        $user = $request->user();
        if ($user == true) {
            return response()->json([
                'status'=>'success',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'danger',
                'message' => 'User tidak ditemukan'
            ]);
        }
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successfully'
        ]);
    }
}
