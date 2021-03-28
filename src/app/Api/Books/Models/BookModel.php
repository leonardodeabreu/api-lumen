<?php

declare(strict_types=1);

namespace App\Api\Books\Models;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    protected $table = 'books';

    protected $fillable
        = [
            'title',
            'isbn',
            'category',
            'year',
        ];

    protected $dates
        = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

    protected $casts
        = [
            'year' => 'number',
        ];
}
