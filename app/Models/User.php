<?php

namespace App\Models;

use App\Enums\DiscordRole;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $nickname
 * @property string $email
 * @property string $discord_id
 * @property \Illuminate\Support\Collection $roles
 * @property \Carbon\Carbon $joined_at
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'email',
        'discord_id',
        'avatar',
        'access_token',
        'refresh_token',
        'roles',
        'joined_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'access_token',
        'refresh_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'roles' => AsCollection::class,
        'joined_at' => 'datetime'
    ];

    public function hasRole (string|Array $role): bool
    {
        $role = is_array($role) ? $role : [$role];

        return $this->roles->intersect($role)->isNotEmpty();
    }

    public function isAdmin (): bool
    {
        return $this->discord_id === config('discord.admin_id') ||
            $this->hasRole([DiscordRole::PRESIDENT, DiscordRole::VICE_PRESIDENT, DiscordRole::EBOARD]);
    }
}
