<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            $response = [
                'meta' => [
                    "success" => false,
                    "errors" => [
                        'Token is Expired'
                    ],
                ]
            ];
            return response()->json($response,401);
        }catch (TokenInvalidException $e) {
            $response = [
                'meta' => [
                    "success" => false,
                    "errors" => [
                        'Token is Invalid'
                    ],
                ]
            ];
            return response()->json($response,401);
        } catch (JWTException $e) {
            $response = [
                'meta' => [
                "success" => false,
                    "errors" => [
                        'Token not found'
                    ],
                ]
            ];
            return response()->json($response, 401);
        }
        return $next($request);
    }
}
