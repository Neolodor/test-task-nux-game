<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\UserDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:64', 'regex:/^[\w\d]+$/i'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{7,14}$/'],
        ];
    }

    public function getUserDTO(): UserDTO
    {
        return new UserDTO(
            login: $this->validated('login'),
            phone: $this->validated('phone'),
        );
    }
}
