<?php

declare(strict_types=1);

namespace App\Base\Dto;

use Illuminate\Support\Collection;

class BaseDTO extends Collection
{
    use DtoTrait;

    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    protected $items = [];
    protected $rules = [];

    private $base_items
        = [
            'limit',
            'paginate',
            'page',
        ];

    /**
     * BaseDTO constructor.
     */
    public function __construct()
    {
        $this->items = array_merge($this->items, $this->base_items);

        parent::__construct($this->items);
    }

    public function populateFromArray(array $data): BaseDTO
    {
        $this->populate($data);

        $this->items = collect($this->items)
            ->filter(function ($value, $key) {
                return !is_numeric($key);
            })
            ->map(function ($value, $key) {
                return $this->filterValue($key, $value);
            })->all();

        return $this;
    }

    public function populate(array $data): void
    {
        $data = array_intersect_key($data, array_flip($this->toArray()));
        collect($data)
            ->filter(function ($value) {
                return !in_array($value, [null, ''], true);
            })
            ->map(function ($value, $key) {
                $this[$key] = $value;
                $key        = array_search($key, $this->items);
                if ($key) {
                    unset($this->items[$key]);
                }
            });
    }

    /**
     * @param string $attribute
     * @param        $value
     *
     * @return bool|int|string
     */
    protected function filterValue(string $attribute, $value)
    {
        if (gettype($value) === 'boolean') {
            return boolval($value);
        }

        if (gettype($value) === 'string') {
            return trim(filter_var($value, FILTER_SANITIZE_STRING));
        }

        if (gettype($value) === 'integer') {
            return intval($value);
        }

        return $value;
    }

    /**
     * @param array      $source
     * @param array|null $rules
     *
     * @return mixed
     */
    public static function fromArray(array $source, ?array $rules = [])
    {
        if (!empty($rules)) {
            return (new static)->populateFromArray($source);
        }

        return (new static)->populateFromArray($source);
    }

    public function getLimit(): ?int
    {
        return $this->items['limit'];
    }

    public function setLimit(int $limit): void
    {
        $this->items['limit'] = $this->filterValue('limit', $limit);
    }

    public function getPaginate(): ?int
    {
        return $this->items['paginate'];
    }

    public function setPaginate(int $paginate): void
    {
        $this->items['paginate'] = $this->filterValue('paginate', $paginate);
    }

    public function getPage(): ?int
    {
        return $this->items['page'];
    }

    public function setPage(int $page): void
    {
        $this->items['page'] = $this->filterValue('page', $page);
    }
}
