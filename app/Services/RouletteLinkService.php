<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RouletteLink;
use App\Models\User;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;

final readonly class RouletteLinkService
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function create(User $user): RouletteLink
    {
        try {
            $link = new RouletteLink();
            $link->setUser($user)->save();

            return $link;
        } catch (\Throwable $exception) {
            $message = 'Failed to create roulette link';
            $this->logger->error($message, [
                'login' => $user->getLogin(),
                'exception' => $exception,
            ]);

            throw new \RuntimeException($message, previous: $exception);
        }
    }

    public function cancelUserActiveLink(User $user): void
    {
        $linkToCancel = RouletteLink::query()
            ->where('user_id', $user->getId())
            ->where('expires_at', '>', Carbon::now())
            ->whereNotNull('cancelled_at')
            ->first();

        if ($linkToCancel) {
            $this->cancel($linkToCancel);
        }
    }

    public function cancel(RouletteLink $link): void
    {
        $link->setCancelledAt(Carbon::now())->save();
    }
}
