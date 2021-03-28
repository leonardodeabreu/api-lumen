<?php

declare(strict_types=1);

namespace App\Base\Validations\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Unique implements Rule
{
    /** @var string */
    private $table;

    /** @var null|string */
    private $column;

    /** @var array|null */
    private $where;

    /** @var array|null */
    private $whereNull;

    /** @var array|null */
    private $whereNot;

    public function __construct(
        string $table,
        ?string $column = null,
        ?array $where = null,
        ?array $whereNull = null,
        ?array $whereNot = null
    ) {
        $this->table     = $table;
        $this->column    = $column;
        $this->where     = $where;
        $this->whereNull = $whereNull;
        $this->whereNot  = $whereNot;
    }

    public function passes($attribute, $value): bool
    {
        $query = DB::table($this->table);

        if (is_array($this->where)) {
            foreach ($this->where as $column => $value) {
                $query->where($column, $value);
            }
        }

        if (is_array($this->whereNot)) {
            $query->where(function ($q) {
                foreach ($this->whereNot as $column => $value) {
                    if (is_array($value)) {
                        $q->whereNotIn($column, $value);
                    }
                    $q->where($column, '!=', $value);
                }
            });
        }

        if (is_array($this->whereNull)) {
            foreach ($this->whereNull as $column) {
                $query->whereNull($column);
            }
        }

        if (empty($this->column)) {
            $this->column = $attribute;
        }

        $column = $query->getGrammar()->wrap($this->column);

        return !$query
            ->whereRaw("lower({$column}) = lower(?)", [$value])
            ->count();
    }

    public function message(): string
    {
        return 'Email should be unique.';
    }
}
