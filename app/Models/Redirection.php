<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Eloquent
 */
class Redirection extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'redirects_to'
    ];

    public function click (): void
    {
        $this->clicks++;
        $this->save();
    }
}
