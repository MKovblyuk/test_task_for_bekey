<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public const TOKEN_PREFIX = 'user_token_';
    public const TOKEN_EXPIRATION_DAYS = 2;

    public function login(array $credentials): ?array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $userToken = $user->createToken(
                self::TOKEN_PREFIX . $user->id,
                ['*'],
                now()->addDays(self::TOKEN_EXPIRATION_DAYS)
            );

            return [
                'token' => $userToken->plainTextToken,
                'userId' => $user->id,
            ];
        }

        return null;
    }

    public function register(array $validated): ?array
    {
        User::create($validated);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userToken = $user->createToken(self::TOKEN_PREFIX . $user->id);

            return [
                'token' => $userToken->plainTextToken,
                'userId' => $user->id,
            ];
        }

        return null;
    }

    public function logout(Request $request): void
    {
        Auth::user()->tokens()->delete();

        if (isset($request->session)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}