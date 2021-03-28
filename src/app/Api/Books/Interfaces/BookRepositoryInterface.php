<?php

declare(strict_types=1);

namespace App\Api\Books\Interfaces;

use App\Api\Books\DTO\BookDTO;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    /** @return Paginator|Collection */
    public function findWhere(BookDTO $bookDTO);

    public function saveFavorites(int $userId, int $bookId): bool;

    public function removeFavorites(int $userId, int $bookId): bool;
}
