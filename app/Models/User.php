<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Declaration the user active status.
     */
    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    const SOURCE_GIT_HUB = 'github';
    const SOURCE_WEB = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'avatar', 'source', 'verification_token', 'introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Declaration the model relationship with Topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Declaration the model relationship with VotedTopics.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votedTopics()
    {
        return $this->belongsToMany(Topic::class, 'votes')->withTimestamps();
    }

    /**
     * Declaration the model relationship with UserSocialite.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userSocialite()
    {
        return $this->hasOne(UserSocialite::class);
    }

    /**
     * Is author of the model.
     *
     * @param $model
     * @return bool
     */
    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    /**
     * The user's data from github.
     *
     * @return mixed|null
     */
    public function githubData()
    {
        $userSocialite = $this->userSocialite();
        return empty($userSocialite) ? json_decode($userSocialite->data) : null ;
    }

    /**
     * Access the routing of user details.
     *
     * @param array $params
     * @return string
     */
    public function link($params = [])
    {
        return route('users.show', array_merge([$this->username], $params));
    }

    /**
     * Whether the user has already vote up for this topic.
     *
     * @param int $topic 话题 id
     * @return bool
     */
    public function hasVotedTopic(int $topic)
    {
        return !! $this->votedTopics()->where('topic_id', '=', $topic)->count();
    }

    /**
     * The user vote up for this topic.
     *
     * @param int $topic 话题 id
     * @return array
     */
    public function voteTopic(int $topic)
    {
        return $this->votedTopics()->toggle($topic);
    }
}
