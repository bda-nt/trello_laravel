<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $created_user = User::create([
            "name" => $request->name,
            "surname" => $request->surname,
            "login" => $request->login,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);
        $token =  $created_user->createToken($created_user->name)->plainTextToken;
        return response()->json([
            'name' => $created_user->name,
            'surname' => $created_user->surname,
            'token_type' => 'Bearer',
            'token' => $token,
            'expires_at' => 'Never'
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token =  $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'token_type' => 'Bearer',
            'token' => $token,
            'expires_at' => 'Never'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Вы успешно вышли из системы',
        ]);
    }
}
