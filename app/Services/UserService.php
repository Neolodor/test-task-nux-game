<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Psr\Log\LoggerInterface;

final readonly class UserService
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function firstOrCreate(UserDTO $dto): User
    {
        try {
            return User::query()->firstOrCreate($dto->toArray());
        } catch (\Throwable $exception) {
            $message = 'Failed to retrieve or create user';
            $this->logger->error($message, [
                'login' => $dto->getLogin(),
                'exception' => $exception
            ]);

            throw new \RuntimeException($message, previous: $exception);
        }
    }
}
