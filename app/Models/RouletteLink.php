<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read string $id
 * @property string $user_id
 * @property string $slug
 * @property null|Carbon $cancelled_at
 * @property Carbon $expires_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property <Collection<RouletteScore>> $scores
 */
class RouletteLink extends Model
{
    use HasUuids;

    protected $table = 'roulette_link';

    protected $guarded = [];

    protected $casts = [
        'cancelled_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function uniqueIds(): array
    {
        return ['id', 'slug'];
    }

    protected static function booted()
    {
        static::creating(function (RouletteLink $model) {
            $model->expires_at = Carbon::now()->addWeek();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(RouletteScore::class, 'link_id', 'id');
    }

    public function setUser(User $user): self
    {
        $this->user()->associate($user);
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setSlug(string $slug): static
    {
        $this->setAttribute('slug', $slug);
        return $this;
    }

    public function getSlug(): string
    {
        return $this->getAttribute('slug');
    }

    public function getUserId(): string
    {
        return $this->getAttribute('user_id');
    }

    public function setCancelledAt(Carbon $cancelledAt): static
    {
        $this->setAttribute('cancelled_at', $cancelledAt);
        return $this;
    }

    public function getExpiresAt(): Carbon
    {
        return $this->getAttribute('expires_at');
    }

    public function getCancelledAt(): ?Carbon
    {
        return $this->getAttribute('cancelled_at');
    }

    public function isActive(): bool
    {
        return $this->getExpiresAt() > Carbon::now() || $this->getCancelledAt()?->isAfter(Carbon::now());
    }
}
