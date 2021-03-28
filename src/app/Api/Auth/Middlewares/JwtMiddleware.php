<?php

declare(strict_types=1);

namespace App\Api\Auth\Middlewares;

use App\Api\Users\Repositories\UserRepository;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    /** @throws Exception */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$token = $request->headers->get('Authorization')) {
            return response()->json([
                'error' => 'Token not provided.',
                'status' => 401,
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error'  => 'Provided token is expired.',
                'status' => 400,
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error'  => 'An error while decoding token.',
                'status' => 400,
            ], 400);
        }

        $user = (new UserRepository())->findByID($credentials->sub);

        $request->auth = $user;

        return $next($request);
    }
}
