<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read string $id
 * @property string $user_id
 * @property string $link_id
 * @property integer $score
 * @property float $reward
 * @property boolean $is_won
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property RouletteLink $link
 */
class RouletteScore extends Model
{
    use HasUuids;

    protected $table = 'roulette_score';

    protected $fillable = [
        'user_id',
        'link_id',
        'score',
    ];

    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(RouletteLink::class, 'link_id', 'id');
    }

    public function setUser(User $user): static
    {
        $this->user()->associate($user);
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setLink(RouletteLink $link): static
    {
        $this->link()->associate($link);
        return $this;
    }

    public function getLink(): RouletteLink
    {
        return $this->link;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setReward(float $reward): static
    {
        $this->setAttribute('reward', $reward);
        return $this;
    }

    public function getReward(): float
    {
        return $this->getAttribute('reward');
    }

    public function setIsWon(bool $isWon): static
    {
        $this->setAttribute('is_won', $isWon);
        return $this;
    }

    public function isWon(): bool
    {
        return $this->getAttribute('is_won');
    }
}
