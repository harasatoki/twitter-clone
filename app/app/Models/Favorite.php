<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;
    public function isFavorite(Int $userId, Int $tweetId) 
    {
        return (boolean) $this->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
    }
    public function storeFavorite(Int $userId, Int $tweetId)
    {
        $this->user_id = $userId;
        $this->tweet_id = $tweetId;
        $this->save();

        return;
    }
    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }
}
