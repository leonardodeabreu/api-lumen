<?php

namespace App\Api\Users\DTO;

use App\Base\Dto\BaseDTO;

class UserDTO extends BaseDTO
{
    protected $items
        = [
            'name',
            'phone',
            'age',
            'email',
            'active',
        ];

    public function getName(): ?string
    {
        return $this->items['name'] ?? null;
    }

    public function setName(string $name): void
    {
        $this->items['name'] = $this->filterValue('name', $name);
    }

    public function getPhone(): ?string
    {
        return $this->items['phone'] ?? null;
    }

    public function setPhone(string $phone): void
    {
        $this->items['phone'] = $this->filterValue('phone', $phone);
    }

    public function getEmail(): ?string
    {
        return $this->items['email'] ?? null;
    }

    public function setEmail(string $email): void
    {
        $this->items['email'] = $this->filterValue('email', $email);
    }

    public function getAge(): ?int
    {
        return $this->items['age'] ?? null;
    }

    public function setAge(int $age): void
    {
        $this->items['age'] = $this->filterValue('age', $age);
    }

    public function setActive(bool $active): void
    {
        $this->items['active'] = $this->filterValue('active', $active);
    }

    public function isActive(): ?bool
    {
        return $this->items['active'] ?? null;
    }
}
