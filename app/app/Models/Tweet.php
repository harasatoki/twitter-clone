<?php

namespace App\Models;

use App\Http\Controllers\FavoritesController;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    /**
     * ユーザーリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * フェイバリットリレーション
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * コメントリレーション
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ユーザータイムライン取得
     *
     * @param int|null $userId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchUserTimeLine(?int $userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate(50);
    }

    /**
     * ツイート数取得
     *
     * @param int|null $userId
     * 
     * @return int
     */
    public function fetchTweetCount(?int $userId)
    {
        return $this->where('user_id', $userId)->count();
    }

    /**
     * タイムライン取得
     *
     * @param int $userId
     * @param array $followIds
     * 
     * @return array
     */
    public function fetchTimeLines(int $userId, array $followIds)
    {
        // 自身とフォローしているユーザIDを結合する
        $followIds[] = $userId;
        return $this->whereIn('user_id', $followIds)->orderBy('created_at', 'DESC')->paginate(50);
    }

    /**
     * ツイート情報取得
     *
     * @param int $tweetId
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchTweet(int $tweetId)
    {
        return $this->with('user')->where('id', $tweetId)->first();
    }

    /**
     *ツイート保存
     *
     * @param int $userId
     * @param array $data
     * 
     * @return void
     */
    public function storeTweet(int $userId, array $data) : void
    {
        $this->user_id = $userId;
        $this->text = $data['text'];
        $this->save();
    }

    /**
     * ツイート詳細取得
     *
     * @param int $userId
     * @param int $tweetId
     * 
     *     
     * @return \Illuminate\Http\Response
     */
    public function fetchTweetEdit(int $userId, int $tweetId)
    {
        return $this->where('user_id', $userId)->where('id', $tweetId)->first();
    }

    /**
     * ツイートアップデート
     *
     * @param int $tweetId
     * @param array $data
     * 
     * @return　void
     */
    public function updateTweet(int $tweetId, array $data) : void
    {
        $this->id = $tweetId;
        $this->text = $data['text'];
        $this->update();
    }

    /**
     * ツイート削除
     *
     * @param int $userId
     * @param int $tweetId
     * 
     * @return　void
     */
    public function destroyTweet(int $userId, int $tweetId) : void
    {
        $this->where('user_id', $userId)->where('id', $tweetId)->delete();
    }
}
