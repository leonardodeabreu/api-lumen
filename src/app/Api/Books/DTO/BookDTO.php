<?php

namespace App\Api\Books\DTO;

use App\Base\Dto\BaseDTO;

class BookDTO extends BaseDTO
{
    protected $items
        = [
            'title',
            'isbn',
            'category',
            'year',
        ];

    public function getTitle(): ?string
    {
        return $this->items['title'] ?? null;
    }

    public function setTitle(string $title): void
    {
        $this->items['title'] = $this->filterValue('title', $title);
    }

    public function getIsbn(): ?string
    {
        return $this->items['isbn'] ?? null;
    }

    public function setIsbn(string $isbn): void
    {
        $this->items['isbn'] = $this->filterValue('isbn', $isbn);
    }

    public function getCategory(): ?string
    {
        return $this->items['category'] ?? null;
    }

    public function setCategory(string $category): void
    {
        $this->items['category'] = $this->filterValue('category', $category);
    }

    public function getYear(): ?int
    {
        return $this->items['year'] ?? null;
    }

    public function setYear(int $year): void
    {
        $this->items['year'] = $this->filterValue('year', $year);
    }
}
