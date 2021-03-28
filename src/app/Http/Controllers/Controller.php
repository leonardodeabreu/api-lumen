<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => env('EXPIRATION_TIME_MINUTES') * 60,
            ]
        ]);
    }

    protected function responseMessage(string $message, ?int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => [
                'message' => $message
            ]
        ], $statusCode);
    }

    protected function responseData($data, ?int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data
        ], $code);
    }
}
