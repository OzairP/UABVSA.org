<?php

namespace App\Models;

use App\Enums\DiscordRole;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nickname
 * @property string $email
 * @property string $discord_id
 * @property \Illuminate\Support\Collection $roles
 * @property \Carbon\Carbon $joined_at
 * @property string $avatar
 * @property string $access_token
 * @property string $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
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

    public function isSuperUser (): bool
    {
        return $this->discord_id === config('discord.admin_id');
    }

    public function isAdmin (): bool
    {
        $adminRoles = [DiscordRole::PRESIDENT->value, DiscordRole::VICE_PRESIDENT->value, DiscordRole::EBOARD->value];

        return $this->isSuperUser() || $this->hasRole($adminRoles);
    }

    /**
     * @return string
     */
    public function resolveRoles (): string
    {
        return $this->roles
            ->map(function ($role) {
                try {
                    return DiscordRole::tryFrom($role)->name;
                } catch (\Exception $e) {
                    return $role;
                }
            })
            ->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
