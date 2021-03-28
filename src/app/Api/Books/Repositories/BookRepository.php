<?php

declare(strict_types=1);

namespace App\Api\Books\Repositories;

use App\Api\Books\DTO\BookDTO;
use App\Api\Books\Interfaces\BookRepositoryInterface;
use App\Api\Books\Models\BookModel;
use App\Api\Books\Services\FavoriteBooksService;
use App\Base\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    protected $model = BookModel::class;

    public function findWhere(BookDTO $bookDTO)
    {
        $query = $this
            ->newQuery()
            ->where(function ($query) use ($bookDTO) {
                $title = $bookDTO->getTitle();
                if ($title !== null) {
                    $query->where('title', 'ilike', "%{$title}%");
                }

                $isbn = $bookDTO->getIsbn();
                if ($isbn !== null) {
                    $query->where('isbn', 'ilike', "%{$isbn}%");
                }

                $category = $bookDTO->getCategory();
                if ($category !== null) {
                    $query->where('category', 'ilike', "%{$category}%");
                }

                $year = $bookDTO->getYear();
                if ($year !== null) {
                    $query->where('year', $year);
                }
            });

        return $this->doQuery($query, $bookDTO->all());
    }

    public function saveFavorites(int $userId, int $bookId): bool
    {
        return DB::transaction(function () use ($userId, $bookId) {
            return FavoriteBooksService::save($userId, $bookId);
        });
    }

    public function removeFavorites(int $userId, int $bookId): bool
    {
        return DB::transaction(function () use ($userId, $bookId) {
            return FavoriteBooksService::delete($userId, $bookId);
        });
    }
}
