<?php

declare(strict_types=1);

namespace App\Base\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /** @var array */
    protected $withoutFields = [];

    /**
     * @param array $fields
     *
     * @return $this
     */
    protected function hide(array $fields): self
    {
        $this->withoutFields = $fields;

        return $this;
    }
}
