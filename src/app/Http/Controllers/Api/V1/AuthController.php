<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    )
    {}

    public function login(LoginUserRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if ($result) {
            return response()->json([
                'message' => 'User successfully logged in',
                'token' => $result['token'],
                'userId' => $result['userId'],
            ], 200);
        }

        return response()->json(['message' => 'Incorrect credentials'], 401);
    }

    public function register(RegisterUserRequest $request)
    {
        $result = $this->authService->register($request->validated());

        if ($result) {
            return response()->json([
                'message' => 'User successfully registered',
                'token' => $result['token'],
                'userId' => $result['userId'],
            ], 201);
        }

        return response()->json(['message' => 'Registration failed'], 500);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return response()->json(['message' => 'User logged out'], 200);
    }
}