<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class CandidateTest extends TestCase
{
    
    private $path = 'api/candidates';
    private $model = \App\Models\Candidate::class;
    private $table = 'candidates';

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

    public function test_create_candidate_test()
    {
        $token = $this->authenticate();

        $data = $this->model::factory()->make();

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token,
                    ])->json('POST',
                            route('api.leads.store'),
                            $data->toArray()
                        );
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ]);

    }

    public function test_show_candidate_test()
    {
        $token      = $this->authenticate();
        $candidate  = $this->model::factory()->create();
        $response   = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token
                    ])->json('GET',
                            route('api.leads.show', [
                                'id' => $candidate->id
                            ])
                        );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ]);
    }

    public function test_list_candidate_test()
    {
        $token      = $this->authenticate();
        $this->model::factory()->count(10)->create();

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token,
                    ])->json('GET',
                            route('api.leads.index')
                        );
        $response->assertOk(200);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ]);
    }

    public function test_unauthorized_test()
    {
        $candidate  = $this->model::factory()->create();
        $response   = $this->withHeaders([
                    ])->json('GET',
                            route('api.leads.show', [
                                'id' => $candidate->id
                            ])
                        );
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
        ]);
    }

    public function test_show_not_found_test()
    {
        $token      = $this->authenticate();
        $response   = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token
                    ])->json('GET',
                            route('api.leads.show', [
                                'id' => -1
                            ])
                        );
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
        ]);
    }

}