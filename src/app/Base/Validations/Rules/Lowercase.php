<?php

namespace App\Base\Validations\Rules;

use Illuminate\Contracts\Validation\Rule;

class Lowercase implements Rule
{
    public function passes($attribute, $value): bool
    {
        return strtolower($value) === $value;
    }

    public function message(): string
    {
        return 'Email should be lowercase.';
    }
}
