<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class SubAdminController extends AuthController
{
    public function __construct(AuthService $authService)
    {
        \Config::set('auth.defaults.guard', 'subadmin-api');
        parent::__construct($authService);
    }

    public function register(Request $request)
    {
        return $this->authService->register($request, 'subadmin');
    }

    public function logout()
    {
        return $this->authService->logout('subadmin');
    }
}

