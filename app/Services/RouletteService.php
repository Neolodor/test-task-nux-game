<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\RouletteSpanAttemptDTO;
use App\Models\RouletteLink;
use App\Models\RouletteScore;

final readonly class RouletteService
{
    public function __construct(
        private RouletteScoreService $rouletteScoreService,
    ) {
    }
    public function span(RouletteLink $link): RouletteScore
    {
        $score = random_int(0, 1_000);
        if ($score > 0) {
            $isWon = $score % 2 === 0;
            $reward = $isWon ? $this->calculateReward($score) : 0;
        } else {
            $isWon = false;
            $reward = 0;
        }

        $spanAttempt = new RouletteSpanAttemptDTO(
            score: $score,
            reward: $reward,
            isWon: $isWon
        );

        return $this->rouletteScoreService->create($link, $spanAttempt);
    }

    private function calculateReward(int $score): float
    {
        if ($score > 900) {
            return round($score * 0.7, 2);
        }

        if ($score > 600) {
            return round($score * 0.5, 2);
        }

        if ($score > 300) {
            return round($score * 0.3, 2);
        }

        return round($score * 0.1, 2);
    }
}
