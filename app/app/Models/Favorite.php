<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    /**
     * いいね情報取得
     *
     * @param int $userId
     * @param int $tweetId
     * 
     * @return boolean
     */
    public function isFavorite(int $userId, int $tweetId) : bool
    {
        return (boolean) $this->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
    }

    /**
     * いいね情報保存
     *
     * @param int $userId
     * @param int $tweetId
     * 
     * @return void
     */
    public function storeFavorite(int $userId, int $tweetId) : void
    {
        $this->user_id = $userId;
        $this->tweet_id = $tweetId;
        $this->save();
    }

    /**
     * いいね情報削除
     *
     * @param int $favoriteId
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroyFavorite(int $favoriteId)
    {
        return $this->where('id', $favoriteId)->delete();
    }

    /**
     * いいね情報取得
     *
     * @param int $userId
     * @param int $tweetId
     * 
     * @return array
     */
    public function fetchFavoriteId(int $userId, int $tweetId){
        return $this->where('user_id', $userId)->where('tweet_id', $tweetId)->pluck('id');
    }

    /**
     * いいね数取得
     *
     * @param int $tweetId
     * 
     * @return int
     */
    public function countFavorite(int $tweetId){
        return $this->where('tweet_id', $tweetId)->count();
    }
}
