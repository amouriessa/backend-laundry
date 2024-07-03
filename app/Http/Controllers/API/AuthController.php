<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Buat token API untuk pengguna
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'status' => 'Registration success!',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = $request->user();
            if ($user->tokens) {
                $user->tokens()->delete();
            }
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json([
                'status' => 'Login success!',
                'token_type' => 'Bearer',
                'access_token' => $token
            ], 201);
        } else {
            return response()->json([
                'status' => 'Login fail!'
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'Logout success!'
        ], 200);
    }
}
