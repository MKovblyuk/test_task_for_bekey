<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(array $validated): ?array;
    public function register(array $validated): ?array;
    public function logout(Request $request): void;
}