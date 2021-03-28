<?php

declare(strict_types=1);

namespace App\Api\Books\Resources;

use App\Base\Resources\BaseResource;

class BookResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'category' => $this->category,
            'isbn'     => $this->isbn,
            'year'     => $this->year,
        ];
    }
}
