<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class JwtTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRegistration()
    {
        $userData = [
            'name' => 'Admin Test',
            'email' => 'admintest@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'user' => [
                    'name' => 'Admin Test',
                    'email' => 'admintest@gmail.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Admin Test',
            'email' => 'admintest@gmail.com',
            'role' => 'admin',
        ]);
    }

    public function testUserLoginWithCorrectCredentials()
    {
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'user',
        ]);

        $credentials = [
            'email' => 'user@gmail.com',
            'password' => '123456',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'user',
                'token',
            ])
            ->assertJson([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ])
            ->assertJsonStructure(['success', 'user', 'token']);
    }

    public function testUserProfileWithAuthentication()
    {
//        $user = User::factory()->create();
        $user = User::create([
            'name' => 'user test',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'user',
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $loginResponse->assertStatus(Response::HTTP_OK);
        $token = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/user');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    }

    public function testUserLogout()
    {
        $user = User::create([
            'name' => 'user test',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'user',
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $loginResponse->assertStatus(Response::HTTP_OK);
        $token = $loginResponse->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'user successfully signed out',
            ]);
    }
}
