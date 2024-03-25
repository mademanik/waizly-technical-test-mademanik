<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function userProfile()
    {
        return $this->authService->userProfile();
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}
