<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AdminController extends AuthController
{
    public function __construct(AuthService $authService)
    {
        \Config::set('auth.defaults.guard', 'admin-api');
        parent::__construct($authService);
    }

    public function register(Request $request)
    {
        return $this->authService->register($request, 'admin');
    }

    public function logout()
    {
        return $this->authService->logout('admin');
    }

}
