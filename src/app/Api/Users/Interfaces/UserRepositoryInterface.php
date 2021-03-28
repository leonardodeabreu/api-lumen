<?php

declare(strict_types=1);

namespace App\Api\Users\Interfaces;

use App\Api\Users\DTO\UserDTO;
use App\Api\Users\Models\UserModel;
use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByCredentials(string $email): ?UserModel;

    /** @return Paginator|Collection */
    public function findWhere(UserDTO $userDTO);
}
