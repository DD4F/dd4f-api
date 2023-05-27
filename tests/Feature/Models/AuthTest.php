<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthTest extends TestCase
{
    # use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::firstOrCreate(
            [
                'username'  => 'Test.User',
            ],
            [
                'name'      => 'TestUser',
                'username'  => 'Test.User',
                'email'     => 'test@gmail.com',
                'password'  => Hash::make('secret123$')
            ]
        );
        $user->syncRoles(['manager']);

        $this->user = $user;
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    /**
     * Test User Login
     *@test
     */

    public function test_auth_login()
    {
        $data = [
            'username'  => 'dd4f',
            'password'  => 'dd4f',
        ];
        $response = $this->withHeaders([
                    ])->json('POST',
                            route('api.auth.login'),
                            $data
                        );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'token',
                'minutes_to_expire',
            ],
        ]);
    }

}