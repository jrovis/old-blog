<?php

namespace App\Models;


class Vote extends Model
{
    //

    public function scopeByWhom($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }
}
