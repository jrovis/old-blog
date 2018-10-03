<?php

namespace App\Models;


class UserSocialite extends Model
{
    const SOURCE_GIT_HUB = 'github';

    protected $fillable = [
        'user_id', 'source', 'data'
    ];

    /**
     * Declaration the model relationship with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
