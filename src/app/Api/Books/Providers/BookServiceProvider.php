<?php

declare(strict_types=1);

namespace App\Api\Books\Providers;

use App\Api\Books\Interfaces\BookRepositoryInterface;
use App\Api\Books\Repositories\BookRepository;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );
    }
}
