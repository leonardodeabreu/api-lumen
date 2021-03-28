<?php

declare(strict_types=1);

namespace App\Base\Repositories;

use App\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    protected $with = [];

    /**
     * @param array $data
     * @param bool $loadRelationships
     * @return Model
     * @throws \Exception
     */
    public function create(array $data, bool $loadRelationships = true): Model
    {
        try {
            $needleData = $this->getPropertiesData($data);

            $query = $this->newQuery()->create($needleData);

            if ($loadRelationships) {
                $query->load($this->with);
            }

            return $query;
        } catch (\Exception | QueryException $e) {
            throw new \Exception($e->getFile(), 500, $e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function update(array $data, int $id): bool
    {
        try {
            $needleData = $this->getPropertiesData($data);

            return $this->findByID($id, ['*'])->update($needleData);
        } catch (\Exception | QueryException $e) {
            throw new \Exception('Bad Request. Failed to execute update.', 400, $e);
        }
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function delete(int $id): ?bool
    {
        try {
            $model = $this->findByID($id, ['id']);

            return $model->delete();
        } catch (\Exception | ModelNotFoundException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }
    }

    /**
     * @return Paginator|Collection
     */
    public function findAll()
    {
        return $this->doQuery();
    }

    /**
     * @param int $id
     * @param array|string[] $columns
     * @return Model|null
     * @throws \Exception
     */
    public function findByID(int $id, array $columns = ['*']): ?Model
    {
        try {
            return $this->newQuery()
                ->with($this->with)
                ->findOrFail($id, $columns);
        } catch (ModelNotFoundException $e) {
            throw new \Exception('Model não encontrado.', 404);
        }
    }

    protected function newQuery(): Builder
    {
        return $this->model()
            ->newQuery();
    }

    /**
     * @param Builder|null $query
     * @param array|null $appends
     * @return Paginator|Collection
     */
    protected function doQuery(?Builder $query = null, ?array $appends = [])
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if (!empty($appends['paginate'])) {
            return $query
                ->with($this->with)
                ->paginate(Arr::get($appends, 'limit', 15))
                ->appends($appends);
        }

        if (!empty($appends['limit'])) {
            $query->take($appends['limit']);
        }

        return $query->with($this->with)->get();
    }

    /**
     * @param array $data
     * @return array
     */
    private function getPropertiesData(array $data): array
    {
        return Arr::only($data, $this->model()->getFillable());
    }

    /**
     * @return Model
     */
    private function model(): Model
    {
        return app($this->model);
    }
}
