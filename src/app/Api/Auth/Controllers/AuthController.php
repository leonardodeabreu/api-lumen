<?php

declare(strict_types=1);

namespace App\Api\Auth\Controllers;

use App\Api\Auth\Services\LoginService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** @throws ValidationException */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('email', 'password');

            if (!$token = LoginService::authenticateUser($credentials)) {
                return $this->responseMessage('Unauthorized User.', 401);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->responseMessage($e->getMessage(), 400);
        }
    }
}
