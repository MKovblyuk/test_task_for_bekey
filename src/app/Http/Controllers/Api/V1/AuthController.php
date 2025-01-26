<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

/**
 * @group Auth management
 *
 * APIs for managing authentication
 */
class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    )
    {}

    /**
     * Login
     * 
     * @unauthenticated
     * 
     * @bodyParam password string required string Example: 12QWERTY_3a
     * 
     * @response 401 {"message": "Incorrect credentials"}
     * 
     * @response 200 {
     *      "message": "User successfully logged in",
     *      "token": "1|YGwScKg7jPnZlviC5tGjfSKYy5sFsEsy5odBftn16977e462",
     *      "userId": 1
     * }
     * 
     * @response 422 {
     *     "message": "Validation Failed",
     *      "errors": {
     *          "email": [
     *              "The email field is required."
     *          ]
     *      }
     * }
     */
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

    /**
     * Register
     * 
     * @unauthenticated
     * 
     * @bodyParam password string required Example: 12QWERTY_3a
     * @bodyParam password_confirmation string required Example: 12QWERTY_3a
     * 
     * @response 500 {"message": "Registration failed"} scenario="Server error"
     * 
     * @response 200 {
     *      "message": "User successfully registered",
     *      "token": "1|YGwScKg7jPnZlviC5tGjfSKYy5sFsEsy5odBftn16977e462",
     *      "userId": 1
     * }
     * 
     * @response 422 {
     *     "message": "Validation Failed",
     *      "errors": {
     *          "name": [
     *              "The name field is required."
     *          ],
     *          "email": [
     *              "The email field is required."
     *          ]
     *      }
     * }
     */
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

    /**
     * Logout
     * 
     * @response 200 {"message": "User logged out"}
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return response()->json(['message' => 'User logged out'], 200);
    }
}