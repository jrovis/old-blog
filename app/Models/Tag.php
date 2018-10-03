<?php

namespace App\Models;


class Tag extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'topics_count', 'creator'
    ];

    /**
     * Declaration the model relationship with Topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topic_tag')->withTimestamps();
    }
}
