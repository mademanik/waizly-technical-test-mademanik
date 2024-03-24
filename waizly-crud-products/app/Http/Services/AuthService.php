<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface AuthService
{
    public function login(Request $request);
    public function register(Request $request, string $role);
    public function logout(string $role);
    public function userProfile();
}
