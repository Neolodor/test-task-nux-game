<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\RouletteSpanAttemptDTO;
use App\Models\RouletteLink;
use App\Models\RouletteScore;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Cache;

class RouletteScoreService
{
    public function create(RouletteLink $link, RouletteSpanAttemptDTO $attempt): RouletteScore
    {
        $score = new RouletteScore();
        $score->setLink($link)
            ->setUser($link->getUser())
            ->setScore($attempt->getScore())
            ->setReward($attempt->getReward())
            ->setIsWon($attempt->isWon())
            ->save();

        $this->updateCache($score);

        return $score;
    }

    private function updateCache(RouletteScore $score): void
    {
        if (Cache::has($score->getLink()->getSlug())) {
            Cache::delete($score->getLink()->getSlug());
        }

        Cache::put($score->getLink()->getSlug(), $this->getAttemptsList($score->getLink()), 600);
    }

    private function getAttemptsList(RouletteLink $link): Enumerable
    {
        return $link->scores()->orderBy('created_at', 'desc')->limit(3)->get();
    }

    public function getHistory(RouletteLink $link): Enumerable
    {
        /** @var null|Enumerable $attemptsList */
        $attemptsList = Cache::get($link->getSlug());

        if ($attemptsList) {
            return $attemptsList;
        }

        return $this->getAttemptsList($link);
    }
}
