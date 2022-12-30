<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\LotusReservation
 *
 * @property int $id
 * @property string $holder_type
 * @property string $name
 * @property string $email
 * @property int $tickets
 * @property string|null $dietary
 * @property string|null $accommodations
 * @property int $charged_price
 * @property int $pending
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereAccommodations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereChargedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereDietary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereHolderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation wherePending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereTickets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotusReservation whereUpdatedAt($value)
 */
	class LotusReservation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Redirection
 *
 * @property int $id
 * @property string $slug
 * @property string $redirects_to
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereRedirectsTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirection whereUpdatedAt($value)
 */
	class Redirection extends \Eloquent {}
}

namespace App\Models{
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

