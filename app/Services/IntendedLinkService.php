<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Session;

final readonly class IntendedLinkService
{
    public function __construct(
        private RouletteLinkService $rouletteLinkService,
    ) {
    }

    public function get(User $user): string
    {
        if (Session::has('url.intended')) {
            return Session::get('url.intended');
        }

        $rouletteLink = $this->rouletteLinkService->create($user);

        return route('roulette.index', [$rouletteLink->getSlug()]);
    }
}
