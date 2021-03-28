<?php

namespace App\Api\Books\Services;

use Illuminate\Support\Facades\DB;

final class FavoriteBooksService
{
    public static function save(int $userId, int $bookId): bool
    {
        return DB::insert(
            "INSERT INTO user_has_books (user_id, book_id, created_at, updated_at) VALUES (?, ?, 'NOW()', 'NOW()')",
            [$userId, $bookId]
        );
    }

    public static function delete(int $userId, int $bookId): bool
    {
        return DB::delete(
            'DELETE FROM user_has_books WHERE user_id = (?) and book_id = (?)',
            [$userId, $bookId]
        );
    }
}
