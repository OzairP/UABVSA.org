<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property string $redirects_to
 * @property int $clicks
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
