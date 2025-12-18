<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

final readonly class UserDTO implements Arrayable
{
    public function __construct(
        private string $login,
        private string $phone,
    ) {
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'phone' => $this->phone,
        ];
    }
}
