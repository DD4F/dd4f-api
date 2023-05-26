<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login( Request $request)
    {
        try {
            # Validamos username y password
            $validated = $request->validate([
                'username' => 'required',
                'password' => 'required|string|min:4',
            ]);
            # Obtenemos las credenciales
            $credentials = request(['username', 'password']);
            # Generamos el token
            if (! $token = auth()->attempt($credentials)) {
                $response = [
                    'meta' => [
                        'success'   => true,
                        'errors'    => [
                            "Password incorrect for: {$request->username}"
                        ],
                    ]
                ];
    
                # return response()->json(['error' => 'Unauthorized'], 401);
                return response()->json($response, 401);
            }
        } catch (\Exception $e) {
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [
                        $e->getMessage()
                    ],
                ]
            ];
            return response()->json($response, 422);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $response = [
            'meta' => [
                'success'   => true,
                'errors'    => [],
            ],
            'data' => [
                'token'             => $token,
                'token_type'        => 'bearer',
                'minutes_to_expire' => auth()->factory()->getTTL() * 24,
            ]
        ];
        return response()->json($response,200);
    }
}