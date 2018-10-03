<?php

namespace App\Models;

use App\Models\Queries\TopicQuery;

class Topic extends Model
{
    use TopicQuery;

    const IS_DELETE = 1;
    const NOT_DELETE = 0;

    protected $fillable = [
        'title', 'body', 'body_original', 'excerpt', 'slug',
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

    /**
     * The model relation with Tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'topic_tag')->withTimestamps();
    }

    /**
     * The model relation with VotedUsers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votedUsers()
    {
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
    }

    /**
     * Access the routing of topic details.
     *
     * @param array $params
     * @return string
     */
    public function link($params = [])
    {
        return route('p.show', array_merge([hashIdEncode($this->id)], $params));
    }
}
