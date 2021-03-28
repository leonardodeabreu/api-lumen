<?php

declare(strict_types=1);

namespace App\Base\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param array $data
     * @param bool  $loadRelationships
     *
     * @return Model
     */
    public function create(array $data, bool $loadRelationships = true): Model;

    /**
     * @param array $data
     * @param int   $id
     *
     * @return bool
     */
    public function update(array $data, int $id): bool;

    /**
     * @param int $id
     *
     * @return bool|null
     */
    public function delete(int $id): ?bool;

    /**
     * @return LengthAwarePaginator|Collection
     */
    public function findAll();

    /**
     * @param int            $id
     * @param array|string[] $columns
     *
     * @return Model|null
     */
    public function findByID(int $id, array $columns = ['*']): ?Model;
}
