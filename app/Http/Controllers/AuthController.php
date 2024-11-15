<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\DefaultResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;
        return new DefaultResource([
            'user' => $user,
            'token' =>$token
        ]);
    }
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }
        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        return new DefaultResource([
            'user' => auth()->user(),
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Deslogado com sucesso.'
        ]);
    }
}
