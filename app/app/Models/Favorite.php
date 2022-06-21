<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    /**
     * いいね情報取得
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return boolean
     */
    public function isFavorite(Int $userId, Int $tweetId)
    {
        return (boolean) $this->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
    }

    /**
     * いいね情報保存
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return void
     */
    public function storeFavorite(Int $userId, Int $tweetId)
    {
        $this->user_id = $userId;
        $this->tweet_id = $tweetId;
        $this->save();

        return;
    }

    /**
     * いいね情報削除
     *
     * @param Int $favoriteId
     * @return void
     */
    public function destroyFavorite(Int $favoriteId)
    {
        return $this->where('id', $favoriteId)->delete();
    }

    /**
     * いいね情報取得
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return void
     */
    public function fetchFavorite(Int $userId, Int $tweetId){
        return $this->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
    }

    /**
     * いいね数取得
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return void
     */
    public function countFavorite(Int $userId, Int $tweetId){
        return $this->where('user_id', $userId)->where('tweet_id', $tweetId)->count();
    }
}
