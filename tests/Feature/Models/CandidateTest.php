<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class CandidateTest extends TestCase
{
    private $model = \App\Models\Candidate::class;

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
        $structure = [
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ];
        $token = $this->authenticate();

        $data = $this->model::factory()->make();

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token,
                    ])->json('POST',
                            route('api.leads.store'),
                            $data->toArray()
                        );
        $response->assertStatus(201);
        $response->assertJsonStructure($structure);

    }

    public function test_show_candidate_test()
    {
        $structure = [
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ];

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
        $response->assertJsonStructure($structure);
    }

    public function test_list_candidate_test()
    {
        $structure = [
            'meta' => [
                'success',
                'errors',
            ],
            'data'
        ];
        $token      = $this->authenticate();
        $this->model::factory()->count(10)->create();

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token,
                    ])->json('GET',
                            route('api.leads.index')
                        );
        $response->assertOk(200);
        $response->assertJsonStructure($structure);
    }

    public function test_unauthorized_test()
    {
        $structure = [
            'meta' => [
                'success',
                'errors',
            ]
        ];
        $candidate  = $this->model::factory()->create();
        $response   = $this->withHeaders([
                    ])->json('GET',
                            route('api.leads.show', [
                                'id' => $candidate->id
                            ])
                        );
        $response->assertStatus(401);
        $response->assertJsonStructure($structure);
    }

    public function test_show_not_found_test()
    {
        $structure = [
            'meta' => [
                'success',
                'errors',
            ]
        ];
        $token      = $this->authenticate();
        $response   = $this->withHeaders([
                        'Authorization' => 'Bearer '. $token
                    ])->json('GET',
                            route('api.leads.show', [
                                'id' => -1
                            ])
                        );
        $response->assertStatus(404);
        $response->assertJsonStructure($structure);
    }

}
