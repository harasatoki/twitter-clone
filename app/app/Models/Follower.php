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

    /**
     * フォローの数取得
     *
     * @param [type] $userId
     * 
     * @return int
     */
    public function fetchFollowCount($userId)
    {
        return $this->where('following_id', $userId)->count();
    }

    /**
     * フォロワーの数取得
     *
     * @param [type] $userId
     * 
     * @return int
     */
    public function fetchFollowerCount($userId)
    {
        return $this->where('followed_id', $userId)->count();
    }

    /**
     * フォロワーのIDを取得
     *
     * @param int $userId
     * 
     * @return array
     */
    public function followedIds(int $userId)
    {
        return $this->where('following_id', $userId)->get('followed_id');
    }
}
