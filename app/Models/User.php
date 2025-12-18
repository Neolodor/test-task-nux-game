<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

/**
 * @property-read string $id
 * @property string $login
 * @property string $phone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'login',
        'phone',
    ];

    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    public function setLogin(string $login): static
    {
        $this->setAttribute('login', $login);
        return $this;
    }

    public function getLogin(): string
    {
        return $this->getAttribute('login');
    }

    public function setPhone(string $phone): static
    {
        $this->setAttribute('phone', $phone);
        return $this;
    }

    public function getPhone(): string
    {
        return $this->getAttribute('phone');
    }

    public function getCreatedAt(): Carbon
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->getAttribute('updated_at');
    }

    public function links(): HasMany
    {
        return $this->hasMany(RouletteLink::class);
    }
}
