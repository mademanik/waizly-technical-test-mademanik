<?php

namespace App\Http\Services;

use App\Models\Admin;
use App\Models\Subadmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthServiceImpl implements AuthService
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            Log::info($validator->info());
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validate())) {
            Log::info('Unauthorized');
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request, string $role)
    {
        if ($role == 'admin') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:admins',
                'password' => 'required|string|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:subadmins',
                'password' => 'required|string|confirmed|min:6',
            ]);
        }

        if ($validator->fails()) {
            Log::info($validator->errors());
            return response()->json($validator->errors()->toJson(), 400);
        }

        if ($role == 'admin') {
            $user = Admin::create(array_merge(
                $validator->validate(),
                ['password' => bcrypt($request->password)]
            ));
        } else {
            $user = Subadmin::create(array_merge(
                $validator->validate(),
                ['password' => bcrypt($request->password)]
            ));
        }

        Log::info($role.' successfully registered');
        return response()->json([
            'message' => $role.' successfully registered',
            'user' => $user
        ], 201);
    }

    public function logout(string $role)
    {
        auth()->logout();
        Log::info($role.' signed out');
        return response()->json(['message' => $role.' successfully signed out']);
    }

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        Log::info(auth()->user()->getAuthIdentifierName().' successfully logged in');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => strtotime(date('Y-m-d H:i:s', strtotime("+60 min"))),
            'user' => auth()->user()
        ]);
    }
}

