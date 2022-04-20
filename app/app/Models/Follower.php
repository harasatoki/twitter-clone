<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];
    protected $fillable = [
        'following_id',
        'followed_id'
    ];
    public $timestamps = false;
    public $incrementing = false;
    public function getFollowCount($userId)
    {
        return $this->where('following_id', $userId)->count();
    }

    public function getFollowerCount($userId)
    {
        return $this->where('followed_id', $userId)->count();
    }
    public function followingIds(Int $userId)
    {
        return $this->where('following_id', $userId)->get('followed_id');
    }
}
