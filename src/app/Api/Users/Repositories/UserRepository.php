<?php

declare(strict_types=1);

namespace App\Api\Users\Repositories;

use App\Api\Users\DTO\UserDTO;
use App\Api\Users\Interfaces\UserRepositoryInterface;
use App\Api\Users\Models\UserModel;
use App\Base\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model = UserModel::class;

    protected $with = ['favoriteBooks'];

    public function findByCredentials(string $email): ?UserModel
    {
        $query = $this
            ->newQuery()
            ->where([
                ['email', $email],
                ['active', true],
            ]);

        return !empty($this->doQuery($query)) ? $this->doQuery($query)->first() : null;
    }

    public function findWhere(UserDTO $userDTO)
    {
        $query = $this
            ->newQuery()
            ->where(function ($query) use ($userDTO) {
                $name = $userDTO->getName();
                if ($name !== null) {
                    $query->where('name', 'ilike', "%{$name}%");
                }

                $email = $userDTO->getEmail();
                if ($email !== null) {
                    $query->where('email', 'ilike', "%{$email}%");
                }

                $phone = $userDTO->getPhone();
                if ($phone !== null) {
                    $query->where('phone', 'ilike', "%{$phone}%");
                }

                $age = $userDTO->getAge();
                if ($age !== null) {
                    $query->where('age', $age);
                }

                $active = $userDTO->isActive();
                if (!empty($active)) {
                    $query->where('active', $active);
                }
            });

        return $this->doQuery($query, $userDTO->all());
    }
}
