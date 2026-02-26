<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'display_name',
    ];

    /**
     * Gets the user that profile belongs to
     * @return BelongsTo<User, Profile>
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
