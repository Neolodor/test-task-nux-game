<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

final readonly class RouletteSpanAttemptDTO implements Arrayable
{
    public function __construct(
        private int $score,
        private float $reward,
        private bool $isWon,
    ) {
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getReward(): float
    {
        return $this->reward;
    }

    public function isWon(): bool
    {
        return $this->isWon;
    }

    public function toArray(): array
    {
        return [
            'score' => $this->getScore(),
            'reward' => $this->getReward(),
            'isWon' => $this->isWon(),
        ];
    }
}
