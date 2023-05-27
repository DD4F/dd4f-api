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