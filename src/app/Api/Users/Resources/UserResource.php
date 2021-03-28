<?php

declare(strict_types=1);

namespace App\Api\Users\Resources;

use App\Base\Resources\BaseResource;

class UserResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'active' => $this->active,
            'email'  => $this->email,
            'age'    => $this->age,
            'phone'  => $this->phone,
        ];
    }
}
