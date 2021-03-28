<?php

declare(strict_types=1);

namespace App\Api\Auth\Services;

use App\Api\Users\Models\UserModel;
use App\Api\Users\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

final class LoginService
{
    /** @throws \Exception */
    public static function authenticateUser(array $credentials): string
    {
        try {
            $email = pg_escape_string($credentials['email']);
            $password = pg_escape_string($credentials['password']);

            $user = self::retrieveUserByCredentials($email);

            if (Hash::check($password, $user->password)) {
                return self::generateToken($user->id);
            }

            throw new \Exception('Failed to login');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    private static function generateToken(int $userId): string
    {
        $needlePayload = [
            'iss' => 'lumen-jwt',
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + (env('EXPIRATION_TIME_MINUTES') * 60),
        ];

        return JWT::encode($needlePayload, env('JWT_SECRET'));
    }

    private static function retrieveUserByCredentials(string $login): ?UserModel
    {
        return (new UserRepository())->findByCredentials($login);
    }
}
