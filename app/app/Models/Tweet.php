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

    /**
     * ユーザーリレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * フェイバリットリレーション
     *
     * @return void
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * コメントリレーション
     *
     * @return void
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ユーザータイムライン取得
     *
     * @param Int|null $userId
     * @return void
     */
    public function fetchUserTimeLine(?Int $userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate(50);
    }

    /**
     * ツイート数取得
     *
     * @param Int|null $userId
     * @return void
     */
    public function fetchTweetCount(?Int $userId)
    {
        return $this->where('user_id', $userId)->count();
    }

    /**
     * タイムライン取得
     *
     * @param Int $userId
     * @param Array $followIds
     * @return void
     */
    public function fetchTimeLines(Int $userId, Array $followIds)
    {
        // 自身とフォローしているユーザIDを結合する
        $followIds[] = $userId;
        return $this->whereIn('user_id', $followIds)->orderBy('created_at', 'DESC')->paginate(50);
    }

    /**
     * ツイート情報取得
     *
     * @param Int $tweetId
     * @return void
     */
    public function fetchTweet(Int $tweetId)
    {
        return $this->with('user')->where('id', $tweetId)->first();
    }

    /**
     *ツイート保存
     *
     * @param Int $userId
     * @param Array $data
     * @return void
     */
    public function storeTweet(Int $userId, Array $data)
    {
        $this->user_id = $userId;
        $this->text = $data['text'];
        $this->save();

        return;
    }

    /**
     * ツイート詳細取得
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return void
     */
    public function fetchTweetEdit(Int $userId, Int $tweetId)
    {
        return $this->where('user_id', $userId)->where('id', $tweetId)->first();
    }

    /**
     * ツイートアップデート
     *
     * @param Int $tweetId
     * @param Array $data
     * @return void
     */
    public function updateTweet(Int $tweetId, Array $data)
    {
        $this->id = $tweetId;
        $this->text = $data['text'];
        $this->update();

        return;
    }

    /**
     * ツイート削除
     *
     * @param Int $userId
     * @param Int $tweetId
     * @return void
     */
    public function destroyTweet(Int $userId, Int $tweetId)
    {

        return $this->where('user_id', $userId)->where('id', $tweetId)->delete();
    }
}
