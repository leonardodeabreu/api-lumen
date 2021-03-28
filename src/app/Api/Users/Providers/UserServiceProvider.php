<?php

declare(strict_types=1);

namespace App\Api\Users\Providers;

use App\Api\Users\Interfaces\UserRepositoryInterface;
use App\Api\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
