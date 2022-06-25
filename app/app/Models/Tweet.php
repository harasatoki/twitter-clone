<?php

namespace App\Models;
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
        $this->userId = $userId;
        $this->text = $data['text'];
        $this->save();

        return;
    }
}
