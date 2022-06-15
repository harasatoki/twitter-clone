<?php

namespace App\Models;

use App\Http\Controllers\FavoritesController;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getUserTimeLine(?Int $userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate(50);
    }

    public function getTweetCount(?Int $userId)
    {
        return $this->where('user_id', $userId)->count();
    }
    public function getTimeLines(Int $userId, Array $followIds)
    {
        // 自身とフォローしているユーザIDを結合する
        $followIds[] = $userId;
        return $this->whereIn('user_id', $followIds)->orderBy('created_at', 'DESC')->paginate(50);
    }
    // 詳細画面
    public function getTweet(Int $tweetId)
    {
        return $this->with('user')->where('id', $tweetId)->first();
    }
    public function tweetStore(Int $userId, Array $data)
    {
        $this->user_id = $userId;
        $this->text = $data['text'];
        $this->save();

        return;
    }
    public function getTweetEdit(Int $userId, Int $tweetId)
    {

        return $this->where('user_id', $userId)->where('id', $tweetId)->first();
    }
    public function tweetUpdate(Int $tweetId, Array $data)
    {
        $this->id = $tweetId;
        $this->text = $data['text'];
        $this->update();

        return;
    }
    public function tweetDestroy(Int $userId, Int $tweetId)
    {

        return $this->where('user_id', $userId)->where('id', $tweetId)->delete();
    }
    public function search(Int $userId, Int $tweetId){
        return $this->favorites()->where('user_id', $userId)->where('tweet_id', $tweetId)->first();
    }
}
